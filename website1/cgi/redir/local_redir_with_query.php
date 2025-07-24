<?php
$query = $_SERVER['QUERY_STRING'];
$location = '/redir_fallback/redir_with_query.php';
if (!empty($query)) {
    $location .= '?' . $query;
}
header("Location: $location");
exit;
?>
