from fastapi import FastAPI

app = FastAPI()

@app.get("/")
def read_root():
    return {"status": "Watchlist FastAPI Stub Working", "domain": "api.watchlist.fgsfds.ai-info.ru"}

@app.get("/ws")
def websocket_stub():
    return {"message": "WebSocket endpoint stub"}
