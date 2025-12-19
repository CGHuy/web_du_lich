.status-label {
display: inline-flex;
align-items: center;
justify-content: center;
min-width: 96px;
height: 34px;
padding: 0 14px;
gap: 8px;
border-radius: 10px;
font-size: 14px;
font-weight: 600;
line-height: 1.2;
border: 1px solid transparent;
white-space: nowrap;
background: #f8fafc;
color: #334155;
}

.status-label.status-info {
background: #e0f2fe;
color: #0369a1;
border-color: #bae6fd;
}

.status-label.status-success {
background: #ecfdf3;
color: #15803d;
border-color: #bbf7d0;
}

.status-label.status-warning {
background: #fef9c3;
color: #b45309;
border-color: #fef08a;
}

.status-label.status-danger {
background: #fef2f2;
color: #b91c1c;
border-color: #fecdd3;
}

.status-label.status-default {
background: #f3f4f6;
color: #334155;
border-color: #e5e7eb;
}

/_ Dark mode (body.dark) _/
.dark .status-label {
background: #1f2937;
color: #e5e7eb;
border-color: #374151;
}

.dark .status-label.status-info {
background: #0b2f4b;
color: #7dd3fc;
border-color: #155e75;
}

.dark .status-label.status-success {
background: #0f2f21;
color: #bbf7d0;
border-color: #166534;
}

.dark .status-label.status-warning {
background: #3b2f0f;
color: #fef08a;
border-color: #b45309;
}

.dark .status-label.status-danger {
background: #3b1414;
color: #fecdd3;
border-color: #991b1b;
}

.dark .status-label.status-default {
background: #111827;
color: #e5e7eb;
border-color: #1f2937;
}

<!-- Cách dùng với Bootstrap -->
<!--
<span class="status-label status-info">Đã xác nhận</span>
<span class="status-label status-warning">Chờ xác nhận</span>
<span class="status-label status-danger">Đã hủy</span>
<span class="status-label status-success">Hoàn tất</span>
<span class="status-label status-default">Mặc định</span>
-->
