import React, { useState, useEffect, useRef } from 'react';
import ReactDOM from 'react-dom/client';

const RealtimeReviewsIsland = () => {
    const [reviews, setReviews] = useState([]);
    const [isConnected, setIsConnected] = useState(false);
    const [pageType, setPageType] = useState(null);
    const socketRef = useRef(null);

    useEffect(() => {
        const container = document.getElementById('realtime-reviews-island');
        if (container) {
            setPageType(container.getAttribute('data-type'));
        }
    }, []);

    useEffect(() => {
        if (!pageType) return;

        const connectWebSocket = () => {
            const wsUrl = `ws://localhost:8000/ws/reviews?type=${pageType}`;
            
            socketRef.current = new WebSocket(wsUrl);

            socketRef.current.onopen = () => {
                setIsConnected(true);
            };

            socketRef.current.onmessage = (event) => {
                try {
                    const newReview = JSON.parse(event.data);
                    
                    if (newReview.type === pageType) {
                        setReviews((prevReviews) => {
                            const updated = [newReview, ...prevReviews];
                            return updated.slice(0, 5);
                        });
                    }
                } catch (error) {
                    console.error("Ошибка обработки входящего отзыва:", error);
                }
            };

            socketRef.current.onclose = () => {
                setIsConnected(false);
                setTimeout(() => {
                    connectWebSocket();
                }, 5000);
            };

            socketRef.current.onerror = (error) => {
                console.error("Сбой соединения WebSocket:", error);
                socketRef.current.close();
            };
        };

        connectWebSocket();

        return () => {
            if (socketRef.current) {
                socketRef.current.close();
            }
        };
    }, [pageType]);

    const formatReviewDate = (dateString) => {
        if (!dateString) return '';
        const date = new Date(dateString);
        return date.toLocaleTimeString('ru-RU', { hour: '2-digit', minute: '2-digit' }) + ' ' + 
               date.toLocaleDateString('ru-RU', { day: 'numeric', month: 'short' });
    };

    return (
        <div class="flex flex-col h-full justify-between space-y-4">
            
            <div class="flex items-center justify-between text-xs border-b border-gray-700/50 pb-2">
                <span class="text-gray-400 font-medium">Мониторинг отзывов</span>
                <div class="flex items-center space-x-1.5">
                    <span class={`h-2 w-2 rounded-full ${isConnected ? 'bg-emerald-500' : 'bg-rose-500 animate-pulse'}`}></span>
                    <span class="text-gray-500">{isConnected ? 'on-line' : 'восстановление связи'}</span>
                </div>
            </div>

            {/* Список отзывов */}
            <div class="flex-1 space-y-4 overflow-y-auto max-h-[500px] pr-1 scrollbar-thin">
                {reviews.length === 0 ? (
                    <div class="flex flex-col items-center justify-center h-[350px] text-center text-gray-500 text-xs px-4">
                        <p class="font-medium">Ожидание новых отзывов...</p>
                        <p class="text-gray-600 mt-1">Как только кто-то оставит отзыв, он мгновенно отобразится здесь без перезагрузки страницы.</p>
                    </div>
                ) : (
                    reviews.map((review, index) => (
                        <div 
                            key={review.id || index} 
                            class="bg-gray-900/50 border border-gray-700/40 rounded-lg p-4 space-y-2.5 hover:border-indigo-500/40 transition duration-200"
                        >
                            <div class="flex items-center justify-between text-xs">
                                <span class="font-bold text-gray-300">{review.username}</span>
                                <div class="flex items-center space-x-1 text-amber-400">
                                    <span class="font-bold">{review.rating}</span>
                                    <span class="text-[10px] text-gray-500">/5</span>
                                </div>
                            </div>
                            
                            <p class="text-xs text-gray-400 font-medium italic truncate">
                                к произведению: {review.work_title}
                            </p>

                            <p class="text-sm text-gray-300 leading-relaxed break-words">
                                {review.text}
                            </p>

                            <div class="text-[10px] text-gray-500 text-right">
                                {formatReviewDate(review.created_at)}
                            </div>
                        </div>
                    ))
                )}
            </div>
        </div>
    );
};

export default RealtimeReviewsIsland;

// Автоматическое монтирование компонента в DOM-структуру Laravel Blade
const targetContainer = document.getElementById('realtime-reviews-island');
if (targetContainer) {
    const root = ReactDOM.createRoot(targetContainer);
    root.render(<RealtimeReviewsIsland />);
}