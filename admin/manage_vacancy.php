<?php
include 'db_connect.php';

if(isset($_POST['action']) && $_POST['action'] == 'save_vacancy'){
    // Get the values from the form
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $position = $_POST['position'];
    $availability = $_POST['availability'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    $date_created = $_POST['date_created']; // Assuming it's in 'YYYY-MM-DD' format
    $deadline = $_POST['deadline']; // Assuming it's in 'YYYY-MM-DD' format

    // Handle empty or invalid deadline by setting it to NULL
    if (empty($deadline) || $deadline == '0000-00-00') {
        $deadline = NULL; // Set to NULL if it's empty or invalid
    }

    // Prepare the SQL query to update the vacancy
    $query = "UPDATE vacancy SET 
                position = ?, 
                availability = ?, 
                description = ?, 
                status = ?, 
                date_created = ?, 
                deadline = ? 
            WHERE id = ?";

    // Prepare statement
    $stmt = $conn->prepare($query);

    // Bind the parameters (ensure we pass them as strings to match the VARCHAR column type)
    $stmt->bind_param("sissssi", $position, $availability, $description, $status, $date_created, $deadline, $id);

    // Execute the query
    $stmt->execute();

    // Check if it was successful
    if ($stmt->affected_rows > 0) {
        echo "Vacancy updated successfully.";
    } else {
        echo "Error updating vacancy.";
    }

}
?>

<?php
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM vacancy WHERE id=" . $_GET['id']);
    $vacancy = $qry->fetch_array(); // Get the row data
    // Assign each column value to a variable
    foreach($vacancy as $k => $v){
        $$k = $v;
    }

    // If deadline is not NULL or '0000-00-00', format the date to 'YYYY-MM-DD'
    if (isset($deadline) && $deadline != '0000-00-00' && $deadline != NULL) {
        $deadline = date('Y-m-d', strtotime($deadline)); // Format date to 'YYYY-MM-DD'
    } else {
        $deadline = ''; // If deadline is NULL or invalid, leave it blank
    }

    // Format date_posted as well (if needed)
    if (isset($date_created)) {
        $date_created = date('Y-m-d', strtotime($date_created)); // Format to 'YYYY-MM-DD'
    }
}
?>

<div class="container-fluid">
    <form action="" id="manage-vacancy">
        <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>" class="form-control">

        <div class="row form-group">
            <div class="col-md-8">
                <label class="control-label">Position Name</label>
                <input type="text" name="position" class="form-control" value="<?php echo isset($position) ? $position : ''; ?>">
            </div>
        </div>

        <div class="row form-group">
            <div class="col-md-8">
                <label class="control-label">Availability</label>
                <input type="number" name="availability" min='1' class="form-control text-right" value="<?php echo isset($availability) ? $availability : ''; ?>">
            </div>
        </div>

        <div class="row form-group">
            <div class="col-md-6">
                <label class="control-label">Date Posted</label>
                <input type="date" name="date_created" class="form-control" value="<?php echo isset($date_created) ? $date_created : date('Y-m-d'); ?>">
            </div>

            <div class="col-md-6">
                <label class="control-label">Deadline</label>
                <input type="date" name="deadline" class="form-control" value="<?php echo isset($deadline) ? $deadline : ''; ?>">
            </div>
        </div>

        <?php if (isset($id)): ?>
        <div class="row form-group">
            <div class="col-md-8">
                <label class="control-label">Status</label>
                <select name="status" class="browser-default custom-select">
                    <option value="1" <?php echo $status == 1 ? "selected" : ''; ?>>Active</option>
                    <option value="0" <?php echo $status == 0 ? "selected" : ''; ?>>Closed</option>
                </select>
            </div>
        </div>
        <?php endif; ?>

        <div class="row form-group">
            <div class="col-md-12">
                <label class="control-label">Description</label>
                <textarea name="description" class="text-jqte"><?php echo isset($description) ? $description : ''; ?></textarea>
            </div>
        </div>
    </form>
</div>

<script>
    $('.text-jqte').jqte();
    $('#manage-vacancy').submit(function(e){
        e.preventDefault();
        start_load();
        $.ajax({
            url: 'ajax.php?action=save_vacancy',
            method: 'POST',
            data: $(this).serialize(),
            success: function(resp){
                if(resp == 1){
                    alert_toast("Data successfully saved.",'success');
                    setTimeout(function(){
                        location.reload();
                    }, 1000);
                } else {
                    alert_toast("Error saving data.", 'error');
                }
            }
        });
    });
</script>
