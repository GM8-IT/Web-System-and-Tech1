<?php
include 'db.php';
$file_id = isset($_GET['file']) ? (int)$_GET['file'] : 0;
if ($file_id <= 0) { http_response_code(400); die('Bad request'); }

$res = $conn->query("SELECT f.*, t.status, t.access_level, t.embargo_until FROM thesis_files f JOIN theses t ON f.thesis_id = t.id WHERE f.id = $file_id LIMIT 1");
if (!$res || $res->num_rows == 0) { http_response_code(404); die('File not found'); }
$f = $res->fetch_assoc();

if ($f['status'] !== 'approved') { http_response_code(403); die('Not available'); }
if ($f['access_level'] === 'embargoed' && !empty($f['embargo_until']) && strtotime($f['embargo_until']) > time()) {
    http_response_code(403); die('Under embargo until ' . htmlspecialchars($f['embargo_until']));
}
if ($f['access_level'] === 'restricted') {
    if (empty($_SESSION['user_id'])) { header('Location: login.php'); exit; }
    $uid = (int)$_SESSION['user_id'];
    $q = $conn->query("SELECT id FROM access_requests WHERE thesis_id = {$f['thesis_id']} AND requester_id = $uid AND status = 'approved' LIMIT 1");
    if (!$q || $q->num_rows == 0) { die('Access restricted. Request access.'); }
}

$path = $f['storage_path'];
if (!is_file($path)) { http_response_code(404); die('File missing'); }

header('Content-Description: File Transfer');
header('Content-Type: ' . $f['mime_type']);
header('Content-Disposition: attachment; filename="' . basename($f['original_name']) . '"');
header('Content-Length: ' . $f['size_bytes']);
readfile($path);
exit;
?>