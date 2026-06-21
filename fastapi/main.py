import asyncio
import json
from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
import redis.asyncio as aioredis
from routers import ws
from contextlib import asynccontextmanager

async def redis_subscriber():
    redis_url = 'redis://redis:6379'
    
    while True:
        try:
            redis = await aioredis.from_url(redis_url,
                socket_timeout=None, 
                socket_connect_timeout=10,
                socket_keepalive=True
            )
            pubsub = redis.pubsub()
            
            await pubsub.psubscribe('*reviews_channel')
            
            while True:
                try:
                    message = await pubsub.get_message(ignore_subscribe_messages=True, timeout=None)
                    if message is None:
                        await asyncio.sleep(0.1)
                        continue
                        
                    if message['type'] not in ('message', 'pmessage'): 
                        continue
                    
                    channel = message['channel'].decode() if isinstance(message['channel'], bytes) else message['channel']
                    raw_data = message['data'].decode() if isinstance(message['data'], bytes) else message['data']
                    data = json.loads(raw_data)
                    
                    if 'reviews_channel' in channel:
                        print(f"=== [WS] Отправляем отзыв клиентам через WebSocket ===", flush=True)
                        await ws.manager.broadcast({
                            'type': 'new_review',
                            'review': data
                        })
                except asyncio.TimeoutError:
                    continue
                    
        except Exception as e:
            await asyncio.sleep(5)


@asynccontextmanager
async def lifespan(app: FastAPI):
    task = asyncio.create_task(redis_subscriber())
    yield
    task.cancel()

app = FastAPI(lifespan=lifespan)

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

@app.get("/")
def read_root():
    return {"status": "Watchlist FastAPI Stub Working", "domain": "api.watchlist.fgsfds.ai-info.ru"}

app.include_router(ws.router)
