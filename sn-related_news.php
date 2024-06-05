
<div class="row sn-slider">
    <?php
    include_once("functions/database.php");

    get_connection();

    // Get the current news ID from the URL (if applicable)
    $currentNewsId = isset($_GET["news_id"]) ? (int)$_GET["news_id"] : null;


    // Get the category of the current news (if applicable)
    $categorySql = "SELECT category_id FROM news WHERE news_id = $currentNewsId";
    $categoryResult = mysqli_query($database_connection, $categorySql);

    if (mysqli_num_rows($categoryResult) == 1) {
        $categoryId = mysqli_fetch_assoc($categoryResult)["category_id"];

        
        $sql = "SELECT news_id, title, thumbnail 
        FROM news 
        WHERE category_id = $categoryId";

        // Exclude the current news article
        if ($currentNewsId) {
        $sql .= " AND news_id != $currentNewsId";
        }

        // Limit results (adjust as needed)
        $sql .= " LIMIT 5";

        $result = mysqli_query($database_connection, $sql);
        ?>

        <?php
        if (mysqli_num_rows($result) > 0) { 
        while($row = mysqli_fetch_assoc($result)) {
        $newsId = $row["news_id"];
        $title = $row["title"];
        $thumbnail = $row["thumbnail"];?>
        <div class="col-md-4">
            <div class="sn-img">
                <img src="<?= $thumbnail ?>" />
                <div class="sn-title">
                    <a href="<?=("?url=news_detail.php&news_id=$newsId") ?>"> <?= $title ?></a>
                </div>
            </div>
        </div>
        <?php }
        } else {?>
        <div>
            <div>
                <div>
                    <a>未发现相关新闻。</a>
                </div>
            </div>
        </div>
        <?php  }
    } else {
    // Handle scenario where current news ID is not found or no category associated with it
    echo "No related news available.";
    }

    // Close the connection
    mysqli_close($database_connection);

    ?>
</div>
