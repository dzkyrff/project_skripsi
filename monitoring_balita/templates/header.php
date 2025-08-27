<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Monitoring Balita | Posyandu</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <style>
    body {
      background-color: #f8f9fa;
      font-size: 16px;
    }
    .sidebar {
      height: 100vh;
      background-color: #007bff;
      color: white;
      position: sticky;
      top: 0;
    }
   .sidebar {
    min-height: 100vh;
    position: sticky;
    top: 0;
   }
    .sidebar a {
      color: white;
      display: block;
      padding: 10px 20px;
      text-decoration: none;
    }
    .sidebar a:hover {
      background-color: #0056b3;
    }
    table th, table td {
      font-size: 16px;
      padding: 12px 10px;
    }
    .btn {
      font-size: 14px;
      padding: 6px 12px;
    }
    .table-responsive {
    overflow-x: auto;
   }
   .table-container {
    max-height: 500px; /* bisa disesuaikan */
    overflow-y: auto;
  }
  </style>
</head>
<body>
<div class="d-flex">
