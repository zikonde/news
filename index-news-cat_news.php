<?php 
include_once("functions/get_url_parameters.php");
include_once("functions/get_news.php");

//�����ѯ�������ŵ�SQL���
$result = get_category_news();
$result_categories = $result[0];
$total_records_by_category = $result[1];
$result_search_by_category_set = $result[2];
    
//�ṩ����ģ����ѯ��form�� 
?> 

<?php 
//��ҳ��ʵ�� 
for($i = 0; $i < count($result_search_by_category_set)-1; $i=$i+2){?>
    <!-- Category News Start-->
    <div class="cat-news">
        <div class="container">
            <div class="row">

                <?php
                for($j = 0; $j < 2; $j++){
                    $cat = mysqli_fetch_assoc($result_categories);
                    $cat_name = $cat["name"];
                    $cat_id = $cat["category_id"];
                    $cat_title = mb_strcut($cat["description"],0,80,"gbk")."...";
                    ?>
                    <div class="col-md-6">
                        <h2><a href="index.php?url=category_list.php&category_id=<?=$cat_id?>&page_size=10" title="<?=$cat_title ?>"><?=$cat_name?></a></h2>
                        <div class="row cn-slider">

                            <?php 
                            if($total_records_by_category[$i+$j] == 0){?>
                                <div>
                                    <div>
                                        <div>
                                            ����Ŀ�������ţ�
                                        </div>
                                    </div>
                                </div>
                                <?php //return;
                            }else{
                                while($row = mysqli_fetch_array($result_search_by_category_set[$i+$j])){ ?> 
                                    <div class="col-md-6">
                                        <div class="cn-img">
                                            <img src="<?=$row['thumbnail']?>" />
                                            <div class="cn-title">
                                                <a href="index.php?url=news_detail.php&news_id= <?php echo $row['news_id']?>" onclick="updateClicked(this.href)"><?php echo mb_strcut($row['title'],0,40,"gbk")?></a>
                                            </div>
                                        </div>
                                    </div>    
                                <?php }
                            }?>

                        </div>
                    </div>
                <?php }
                ?>

            </div>
        </div>
    </div>
    <!-- Category News End-->

<?php 
}
?>  


