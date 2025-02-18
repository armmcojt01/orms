<?php
ob_start();
$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();

if($action == 'login'){
	$login = $crud->login();
	if($login)
		echo $login;
}
if($action == 'login2'){
	$login = $crud->login2();
	if($login)
		echo $login;
}
if($action == 'logout'){
	$logout = $crud->logout();
	if($logout)
		echo $logout;
}
if($action == 'logout2'){
	$logout = $crud->logout2();
	if($logout)
		echo $logout;
}
if($action == 'save_user'){
	$save = $crud->save_user();
	if($save)
		echo $save;
}
if($action == 'delete_user'){
	$save = $crud->delete_user();
	if($save)
		echo $save;
}
if($action == 'signup'){
	$save = $crud->signup();
	if($save)
		echo $save;
}
if($action == "save_settings"){
	$save = $crud->save_settings();
	if($save)
		echo $save;
}
if($action == "save_recruitment_status"){
	$save = $crud->save_recruitment_status();
	if($save)
		echo $save;
}
if($action == "delete_recruitment_status"){
	$save = $crud->delete_recruitment_status();
	if($save)
		echo $save;
}
if($action == "save_vacancy"){
	$save = $crud->save_vacancy();
	if($save)
		echo $save;
}
if($action == "delete_vacancy"){
	$save = $crud->delete_vacancy();
	if($save)
		echo $save;
}
// if($action == "save_application"){
//     $save = $crud->save_application();
//     if($save)
//         echo $save;
// }

// if($action == "send_email_notification"){
//     $send = $crud->send_email_notification();
//     if($send)
//         echo $send;
// }

// if($action == "save_application"){
//     $save = $crud->save_application();
//     echo $save;
// 	header("Location: sampleForm.php?");
// }
if ($action == "save_application") {
    $save = $crud->save_application();  

	$response = json_decode($save, true);

    if ($response && isset($response['status']) && $response['status'] == 'success') {
        echo json_encode([
            'status' => 'success',
            'email' => $response['email'], 
            'position_id' => $response['position_id'] 
        ]);
    } else {
        echo json_encode([
            'status' => 'error', 
            'message' => 'Failed to submit the application.'
        ]);
    }
}

if ($action == "update_application") {
    $save = $crud->update_application(); // This returns a JSON string

    // Decode the returned JSON to extract position_id
    $response = json_decode($save, true); 

    if ($response && isset($response['status']) && $response['status'] == 'success') {
        echo json_encode([
            'status' => 'success',
            'email' => $response['email'], 
            'position_id' => $response['position_id'] 
        ]);
    } else {
        echo json_encode([
            'status' => 'error', 
            'message' => 'Failed to submit the application.'
        ]);
    }
}


if($action == "delete_application"){
	$save = $crud->delete_application();
	if($save)
		echo $save;
}