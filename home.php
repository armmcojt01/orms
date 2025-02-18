<?php 
include 'admin/db_connect.php'; 
?>
<style>
#portfolio .img-fluid{
    width: calc(100%);
    height: 30vh;
    z-index: -1;
    position: relative;
    padding: 1em;
}
.vacancy-list {
    cursor: pointer;
}
span.highlight {
    background: yellow;
}
</style>

<header class="masthead">
    <div class="container-fluid h-100">
        <div class="row h-100 align-items-center justify-content-center text-center">
            <div class="col-lg-8 align-self-end mb-4 page-title">
                <h3 class="text-white">Welcome to <?php echo $_SESSION['setting_name']; ?></h3>
                <hr class="divider my-4" />
                <div class="col-md-12 mb-2 text-left">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="text-center">Find Vacancies</h4>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="filter" placeholder="Search vacancies...">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fa fa-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                        
            </div>
        </div>
    </div>
</header>

<section id="list">
    <div class="container mt-3 pt-2">
        <h4 class="text-center">List of Vacancy</h4>
        <hr class="divider">
        <?php
        $vacancy = $conn->query("SELECT * FROM vacancy ORDER BY date(date_created) DESC");
        while ($row = $vacancy->fetch_assoc()):
            // Format deadline if available
            $deadline = $row['deadline'];
            $formatted_deadline = '';
            if ($deadline != '0000-00-00' && !empty($deadline)) {
                $formatted_deadline = date('F j, Y', strtotime($deadline)); 
            } else {
                $formatted_deadline = 'Not specified';
            }

            // HTML entity decode for description
            $trans = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
            unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
            $desc = strtr(html_entity_decode($row['description']), $trans);
            $desc = str_replace(array("<li>", "</li>"), array("", ","), $desc);
        ?>
        <div class="card vacancy-list" data-id="<?php echo $row['id'] ?>">
            <div class="card-body">
                <h3><b class="filter-txt"><?php echo $row['position'] ?></b></h3>

                <!-- Display Deadline -->
                <div class="deadline" style="float: right; margin-top: -40px;">
                    <small><strong>Deadline: </strong><?php echo $formatted_deadline; ?></small>
                </div>
                
                <span><small>Needed: <?php echo $row['availability'] ?></small></span>
                <hr>
                <larger class="truncate filter-txt"><?php echo strip_tags($desc) ?></larger>
                <br> 

                <hr class="divider" style="max-width: calc(80%)">
            </div>
        </div>
        
        <br>
        <?php endwhile; ?>
    </div>
</section>

<script>
    $('.card.vacancy-list').click(function(){
        location.href = "index.php?page=view_vacancy&id=" + $(this).attr('data-id');
    });

    $('#filter').keyup(function(e){
        var filter = $(this).val().toLowerCase(); // Get the filter value and convert to lowercase

        $('.card.vacancy-list').each(function() {
            var title = $(this).find('.filter-txt').text().toLowerCase(); // Get the text of the title

            // Check if the title contains the filter text
            if (title.includes(filter)) {
                $(this).show(); // Show the card if it matches
            } else {
                $(this).hide(); // Hide the card if it doesn't match
            }
        });
    });
</script>
