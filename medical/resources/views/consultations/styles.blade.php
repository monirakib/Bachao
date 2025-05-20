<style>
    .consultation-container {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 20px;
        padding: 20px;
        margin-top: 90px;
        height: calc(100vh - 110px);
    }

    .sidebar {
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .participant-info {
        text-align: center;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }

    .avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        margin-bottom: 10px;
    }

    .appointment-details {
        padding: 20px 0;
        border-bottom: 1px solid #eee;
    }

    .chat-container {
        flex: 1;
        display: flex;
        flex-direction: column;
        margin-top: 20px;
    }

    .messages {
        flex: 1;
        overflow-y: auto;
        padding: 10px;
        background: #f8f9fa;
        border-radius: 10px;
        margin-bottom: 10px;
    }

    .message {
        margin-bottom: 10px;
        padding: 8px 12px;
        border-radius: 15px;
        max-width: 80%;
    }

    .message.sent {
        background: #dd2476;
        color: white;
        margin-left: auto;
    }

    .message.received {
        background: #f1f1f1;
    }

    .chat-input {
        display: flex;
        gap: 10px;
    }

    .chat-input input {
        flex: 1;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .main-content {
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .video-container {
        aspect-ratio: 16/9;
        background: #2c3e50;
        border-radius: 10px;
        overflow: hidden;
    }

    .controls {
        display: flex;
        gap: 10px;
        justify-content: center;
    }

    .control-btn {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        border: none;
        background: #f8f9fa;
        color: #2c3e50;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .control-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .control-btn.end-call {
        background: #e74c3c;
        color: white;
    }

    .prescription-panel {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
    }

    .form-group textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        resize: vertical;
    }

    .save-btn {
        background: #dd2476;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .save-btn:hover {
        background: #c41c5f;
    }
</style>