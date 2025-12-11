.status-label {
display: inline-flex;
align-items: center;
justify-content: center;
min-width: 80px;
height: 32px;
padding: 0 14px;
gap: 8px;
border-radius: 8px;
font-size: 14px;
font-weight: 600;
background: #fff;
color: #334155;
border: none;
white-space: nowrap;
}

.status-label.status-success {
background: #ecfdf3;
color: #15803d;
}

<div class="status-label status-success">Đã xác nhận</div>
.status-label.status-warning {
background: #fef9c3;
color: #b45309;
}
<div class="status-label status-warning">Chờ xác nhận</div>
.status-label.status-danger {
background: #fef2f2;
color: #b91c1c;
}
<div class="status-label status-danger">Đã hủy</div>
.status-label.status-default {
background: #f3f4f6;
color: #334155;
}

/_ Dark mode (nếu dùng class .dark ở body) _/
.dark .status-label {
background: #1e293b;
color: #e0e7ef;
border: none;
}
.dark .status-label.status-success {
background: #134e2f;
color: #bbf7d0;
}
.dark .status-label.status-warning {
background: #b45309;
color: #fef9c3;
}
.dark .status-label.status-danger {
background: #7f1d1d;
color: #fecaca;
}
.dark .status-label.status-default {
background: #334155;
color: #e0e7ef;
}
