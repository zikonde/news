
<?php include_once("includes/sn-model.php"); ?>

<ul>
    <?php 
    if($total_records == 0){?>
        <p>тщнчпбнеё║</p>
        <?php 
    }else{
        while($row = mysqli_fetch_array($result_set_categories)){ ?>
            <li><a href="index.php?url=category_list.php&category_id=<?=$row['category_id']?>&page_size=10" ><?php echo $row['name']?></a><span>(<?php echo $row['total_news']?>)</span></li>
        <?php  }
    }
    ?>
</ul>