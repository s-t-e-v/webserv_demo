<?php
// filepath: /home/sbandaog/42/webserv/www/website1/cgi/post/multi_upload.php

header('Content-Type: text/html; charset=utf-8');

function parseMultipartFormData($rawBody, $boundary) {
    $files = [];
    $parts = explode('--' . $boundary, $rawBody);
    foreach ($parts as $part) {
        if (trim($part) === '' || $part === '--') continue;
        $headerEnd = strpos($part, "\r\n\r\n");
        if ($headerEnd === false) continue;
        $headers = substr($part, 0, $headerEnd);
        $content = rtrim(substr($part, $headerEnd + 4), "\r\n");
        if (preg_match(
            '/Content-Disposition:\s*form-data;\s*name="([^"]+)"(?:;\s*filename="([^"]*)")?/i',
            $headers,
            $m
        )) {
            $fileName = $m[2] ?? null;
            if ($fileName !== null && $fileName !== '') {
                $contentType = 'application/octet-stream';
                if (preg_match('/Content-Type:\s*([^\r\n]+)/i', $headers, $t)) {
                    $contentType = trim($t[1]);
                }
                $files[] = [
                    'name'    => $fileName,
                    'content' => $content,
                    'size'    => strlen($content),
                    'type'    => $contentType,
                ];
            }
        }
    }
    return $files;
}

$isPost        = ($_SERVER["REQUEST_METHOD"] === "POST");
$uploadResults = [];
$totalFiles    = 0;
$successCount  = 0;
$errorCount    = 0;
$currentTime   = date('Y-m-d H:i:s');
$uploadDir     = "../../uploads/";

if ($isPost) {
    $rawBody     = file_get_contents("php://input");
    $contentType = $_SERVER["CONTENT_TYPE"] ?? '';
    if (preg_match('/boundary=([^;]+)/', $contentType, $m)) {
        $boundary = trim($m[1], '"');
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        $files      = parseMultipartFormData($rawBody, $boundary);
        $totalFiles = count($files);
        foreach ($files as $file) {
            $name   = $file['name'];
            $size   = $file['size'];
            $type   = $file['type'];
            $result = [
                'name'    => htmlspecialchars($name),
                'size'    => $size,
                'type'    => $type,
                'status'  => 'error',
                'message' => 'Unknown error'
            ];
            if ($size > 0 && $name !== '') {
                $target = $uploadDir . basename($name);
                if (file_put_contents($target, $file['content']) !== false) {
                    $result['status']  = 'success';
                    $result['message'] = 'Upload successful';
                    $successCount++;
                } else {
                    $result['message'] = 'Failed to write file';
                    $errorCount++;
                }
            } else {
                $result['message'] = 'Empty file or invalid filename';
                $errorCount++;
            }
            $uploadResults[] = $result;
        }
    } else {
        $errorCount = 1;
        $uploadResults[] = [
            'name'=>'Unknown','size'=>0,
            'type'=>'Unknown','status'=>'error',
            'message'=>'Invalid multipart boundary'
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title><?= $isPost ? 'Files Uploaded Successfully' : 'Multi-File Upload Demo' ?> – Webserv</title>
  <link rel="stylesheet" href="/css/style.css">
  <link rel="stylesheet" href="/css/upload-preview.css">
</head>
<style>
.action-buttons {
  display: flex;
  gap: 15px;
  justify-content: center;
  margin: 30px 0;
  flex-wrap: wrap;
}

.action-btn {
  padding: 12px 24px;
  border-radius: 8px;
  text-decoration: none;
  font-weight: 600;
  font-size: 16px;
  transition: all 0.3s ease;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.btn-primary {
  background: linear-gradient(135deg, #8e44ad, #9b59b6);
  color: white;
}

.btn-primary:hover {
  background: linear-gradient(135deg, #7d3c98, #8e44ad);
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(142, 68, 173, 0.3);
}

.btn-secondary {
  background: linear-gradient(135deg, #e74c3c, #f39c12);
  color: white;
}

.btn-secondary:hover {
  background: linear-gradient(135deg, #c0392b, #e67e22);
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3);
}

@media (max-width: 600px) {
  .action-buttons {
    flex-direction: column;
    align-items: center;
  }
  
  .action-btn {
    width: 100%;
    max-width: 280px;
    justify-content: center;
  }
}
</style>
<body class="upload-theme">

  <header>
    <h1><?= $isPost ? '📤 Files Uploaded Successfully' : '📁 Multi-File Upload Demo' ?></h1>
    <p><?= $isPost ? 'Your files have been processed by PHP CGI' : 'Test multiple file upload with multipart/form-data' ?></p>
  </header>

  <main class="container">
  <?php if ($isPost): ?>
    <section class="summary-card">
      <h2>Upload Summary</h2>
      <p>Total: <?= $totalFiles ?> file(s)</p>
      <p>Successful: <?= $successCount ?></p>
      <p>Failed: <?= $errorCount ?></p>
      <p>Processed at: <?= $currentTime ?></p>
    </section>
    <section class="file-list">
      <?php foreach($uploadResults as $r): ?>
      <div class="file-item <?= $r['status'] ?>">
        <span class="file-icon"><?= $r['status']==='success'?'✅':'❌' ?></span>
        <div class="file-details">
          <strong><?= $r['name'] ?></strong>
          <small><?= number_format($r['size']/1024,2) ?> KB • <?= $r['type'] ?></small>
        </div>
        <div class="file-status"><?= $r['message'] ?></div>
      </div>
      <?php endforeach; ?>
    </section>
    <div class="action-buttons">
      <a href="<?= $_SERVER['SCRIPT_NAME'] ?>" class="action-btn btn-primary">
        📁 Upload More Files
      </a>
      <a href="/uploads/" class="action-btn btn-secondary" target="_blank">
        📂 Browse Uploaded Files
      </a>
    </div>

  <?php else: ?>
    <form id="uploadForm" action="<?= $_SERVER['SCRIPT_NAME']?>" method="POST" enctype="multipart/form-data">
      <div class="upload-zone" id="uploadZone">
        <div>
          <span id="uploadIcon">📁</span>
          <h3 id="uploadTitle">Choose files or drag them here</h3>
          <p id="uploadSubtitle">You can select multiple files at once</p>
          <div class="drag-instructions">Supports drag & drop • Click to browse</div>
        </div>
        <input type="file" id="fileInput" name="files[]" multiple>
      </div>

      <div class="files-preview" id="filesPreview">
        <div class="files-preview-header">
          <h4>📋 Selected Files <span class="file-counter" id="fileCounter">0</span></h4>
          <button type="button" class="clear-all-btn" onclick="clearAllFiles()">🗑️ Clear All</button>
        </div>
        <div id="filesList"></div>
        <div class="summary-card" id="summary"></div>
      </div>

      <button type="submit" id="submitBtn" class="upload-btn" disabled>
        Select files to upload
      </button>
    </form>

    <div class="upload-card">
      <h3 style="color: #e74c3c; margin-bottom: 15px;">🔍 How It Works</h3>
      <p>When you submit files, the following happens:</p>
      <ol style="margin: 15px 0 15px 20px; line-height: 1.8;">
        <li>Browser sends <span class="highlight">POST</span> request with multipart/form-data</li>
        <li>Custom PHP parser processes the multipart body</li>
        <li>Files are saved to <code><?= $uploadDir ?></code></li>
        <li>Server returns detailed upload results</li>
      </ol>

      <div class="code-block">
<span style="color: #ff6b6b;">POST</span> <span style="color: #4ecdc4;"><?= $_SERVER["SCRIPT_NAME"] ?></span> <span style="color: #95e1d3;">HTTP/1.1</span><br>
<span style="color: #ffe66d;">Content-Type:</span> multipart/form-data; boundary=----WebKitFormBoundary...<br>
<span style="color: #ffe66d;">Content-Length:</span> [file sizes]<br><br>
<span style="color: #95e1d3;">------WebKitFormBoundary...</span><br>
<span style="color: #95e1d3;">Content-Disposition: form-data; name="files[]"; filename="file1.txt"</span><br>
<span style="color: #95e1d3;">[file data]</span>
      </div>
    </div>

    <div class="upload-card">
      <h3 style="color: #e74c3c; margin-bottom: 15px;">⚙️ Features</h3>
      <ul style="margin: 15px 0 15px 20px; line-height: 1.8;">
        <li><strong>🖱️ Drag & Drop:</strong> Drag files directly onto the upload zone</li>
        <li><strong>📁 Multiple Selection:</strong> Select multiple files at once</li>
        <li><strong>🗑️ File Management:</strong> Remove individual files or clear all before upload</li>
        <li><strong>📊 Live Preview:</strong> See file details and total size</li>
        <li><strong>🔍 File Types:</strong> Smart file type detection with icons</li>
        <li><strong>✨ Animations:</strong> Smooth transitions and visual feedback</li>
      </ul>
    </div>

    <section class="back-navigation" style="text-align: center;">
      <a href="/demo/post.html" class="back-button" style="background: rgba(255, 255, 255, 0.9);">
        <span class="back-button-icon">⬅️</span>
        <span>Back to POST Demo</span>
      </a>
    </section>

    <script src="/js/upload-preview.js"></script>
  <?php endif; ?>
  </main>

  <footer style="background: rgba(0, 0, 0, 0.2);">
    <div class="footer-content">
      <p>&copy; 2025 Webserv Project. <?= $isPost ? 'Files processed by PHP CGI.' : 'Multi-file upload demonstration.' ?></p>
      <div class="footer-links">
        <a href="/">Main Demo</a>
        <a href="/demo/post.html">POST Tests</a>
        <a href="/uploads/">View Uploads</a>
      </div>
    </div>
  </footer>
</body>
</html>
