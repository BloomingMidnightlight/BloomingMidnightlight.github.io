<?php
// small helpers
function esc($s) {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

// Other functions...

function logActivity($conn, $actionType, $entity, $description, $user) {
    $stmt = $conn->prepare("
        INSERT INTO activity_log (action_type, entity, description, user) 
        VALUES (?, ?, ?, ?)
    ");
    $stmt->bind_param('ssss', $actionType, $entity, $description, $user);
    $stmt->execute();
    $stmt->close();
}

?>