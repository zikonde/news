<!DOCTYPE html>
<html lang="en">
<head>
    <title>�������</title>
    <link href="img/favicon.ico" rel="icon">
</head>
<body>
        

    <?php include_once "top_and_nav_bar.php" ?>

            
    <div id="mainfunction"> 
        <?php 
        include_once("functions/get_news.php"); 
        include_once("functions/get_url_parameters.php"); 

        //������ģ����ѯ��ȡ��ģ����ѯ�Ĺؼ���keyword 
        $keyword_search = addslashes($keyword);
        
        $total_records =get_news_count($keyword_search);
        $result_set = get_matching($keyword_search, $page_size, $page_current);  
            
        //�ṩ����ģ����ѯ��form�� 
        ?> 
        <!-- <form action="index.php?url=news_list.php" method="get" name = 'f1' onsubmit="check()">
            ������ؼ��֣�<input type="text" name="keyword" value="<?//php echo $keyword?>"> 
            <input type="submit" value="����"> 
             -->
            <br/> 
            
            <table class="nl-table"> 
                <?php 
                //��ҳ��ʵ�� 
                if($total_records==0){ 
                    echo("���޼�¼��"); 
                    //exit("���޼�¼��"); 
                }else{ ?>
                    <tr><h1 class="sn-title" style="text-align: center;">ϵͳ�����������£�</h1></tr>
                    <?php
                    while($row = mysqli_fetch_array($result_set)){ 
                        ?> 
                        <tr> 
                            <td> 
                            <img src="<?php echo $row['thumbnail'];?>" width="150px"> 
                            </td>
                            <td> 
                            <a href="index.php?url=news_detail.php&keyword=<?php echo $keyword?>&news_id= <?php echo $row['news_id']?>"> <?php echo mb_strcut($row['title'],0,40,"gbk")?></a> 
                            </td>
                            <?php 
                            if(is_admin()){ 
                            ?> 
                                <td> 
                                <a href="index.php?url=news_add.php&news_id=<?php echo $row['news_id']?>">�༭</a> 
                                </td> 
                                <td> 
                                <a href="index.php?url=news_delete.php&news_id=<?php echo $row['news_id']?>" onclick="return confirm('ȷ��ɾ����');">ɾ��</a> 
                                </td> 
                            <?php } ?> 
                        </tr> 
                        <?php 
                    } 
                //��ӡ��ҳ������
                $url = $_SERVER["REQUEST_URI"]; 
                page($total_records,$page_size,$page_current,$url,$keyword); 
                }
                ?>  
            </table> 

        </form> 
    </div> 
            
        
    <?php include_once "footer.php" ?>
        
            
</body>
</html>