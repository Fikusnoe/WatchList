import asyncio
import json
from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
import redis.asyncio as aioredis
from routers import ws

app = FastAPI()

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

@app.get("/ws")
def websocket_stub():
    return {"message": "WebSocket endpoint stub"}

app.include_router(ws.router)

async def redis_subscriber_loop():
    redis_url = "redis://redis:6379/0"
    
    while True:
        try:
            client = aioredis.from_url(redis_url, decode_responses=True)
            pubsub = client.pubsub()
            
            await pubsub.subscribe('new_review')
            
            async for message in pubsub.listen():
                if message and message['type'] == 'message':
                    review_payload = json.loads(message['data'])
                    await ws.manager.broadcast({
                        'type': 'new_review',
                        'review': review_payload
                    })
        except Exception as e:
            await asyncio.sleep(5)

@app.on_event('startup')
async def startup_event():
    asyncio.create_task(redis_subscriber_loop())