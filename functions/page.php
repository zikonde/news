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
    

    //�ж�$url���Ƿ���ڲ�ѯ�ַ��� 
    $parse_url = parse_url($url); 
    if(empty($parse_url["query"])){ 
           $url = $url.'?';//�������ڣ���$url����ӣ� 
    }else{ 
        if(isset($_GET["page_current"])){
            $url = preg_replace('/'.'page_current'.'=[^&]+(&|$)/', '$1', $url);
        }
        $url = ($url[strlen($url)-1] == "&")?$url:$url.'&';
    } 

    $navigator = ""; 
    if(!(!$has_page_previous and !$has_page_next)){
        if($has_page_previous)$navigator = "<a href=".$url."page_current=$page_previous>��һҳ</a>  "; 
        for($i=$page_start;$i<$page_end;$i++){ 
              $j = $i+1; 
              $navigator = $navigator."<a href='".$url."page_current=$j'>$j</a>  "; 
        } 
        if($has_page_next)$navigator = $navigator."<a href=".$url."page_current=$page_next>��һҳ</a>"; 
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
                    <?php echo "��".$total_records."����¼����".$total_pages."ҳ����ǰ�ǵ�".$page_current."ҳ"; ?>
                </td>
            </tr>
        </table>
    <?php
    } 
}

//page(300,3,1,$_SERVER["REQUEST_URI"],''); 
?>