<?php 
if($_SERVER["PHP_SELF"] === "/functions/page.php"){
  header("location:../index.php");
}

function page($total_records,$page_size,$page_current,$url,$keyword){ 
    $total_pages = ceil($total_records/$page_size); 
    if($page_current>$total_pages){
        $page_current = $total_pages;
    }else if($page_current<1){
        $page_current = 1;
    }
    $has_page_previous = ($page_current>1);
    $has_page_next = ($page_current<$total_pages);
    $page_previous = ($has_page_previous?$page_current-1:$page_current); 
    $page_next = ($has_page_next)?$page_current+1:$total_pages; 
    $page_start = ($page_current-5>0)?$page_current-5:0; 
    $page_end = ($page_start+10<$total_pages)?$page_start+10:$total_pages;
    $page_start = ($page_end - $page_start >= 10)?$page_end - 10: 0 ;
    

    //判断$url中是否存在查询字符串 
    $parse_url = parse_url($url); 
    if(empty($parse_url["query"])){ 
           $url = $url.'?';//若不存在，在$url后添加？ 
    }else{ 
        if(isset($_GET["page_current"])){
            $url = preg_replace('/'.'page_current'.'=[^&]+(&|$)/', '$1', $url);
        }
        $url = ($url[strlen($url)-1] == "&")?$url:$url.'&';
    } 

    $navigator = ""; 
    if(!(!$has_page_previous and !$has_page_next)){
        if($has_page_previous)$navigator = "<a href=".$url."page_current=$page_previous>上一页</a>  "; 
        for($i=$page_start;$i<$page_end;$i++){ 
              $j = $i+1; 
              $navigator = $navigator."<a href='".$url."page_current=$j'>$j</a>  "; 
        } 
        if($has_page_next)$navigator = $navigator."<a href=".$url."page_current=$page_next>下一页</a>"; 
        ?>
        <table>
            <tr>
                <td>
                    <select name="page_size" id='page_size' style="text-align: center;">
                        <option value="3">3</option>
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                    </select>
                </td>
                <td>
                    <?php echo $navigator; ?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <?php echo "共".$total_records."条记录，共".$total_pages."页，当前是第".$page_current."页"; ?>
                </td>
            </tr>
        </table>
    <?php
    } 
}

//page(300,3,1,$_SERVER["REQUEST_URI"],''); 
?>