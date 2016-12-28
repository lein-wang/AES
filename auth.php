<?php
include_once './phpAES/AES.class.php';
/**
 * Description of auth
 *
 * @author wanglei
 */
/*
|--------------------------------------------------------------------------
| 判断奇偶
| 根据时间戳+版本号生成秘钥
|--------------------------------------------------------------------------
| 
|
*/
function genSK($sdk_version) {
//    $start = microtime();
    $token = microtime() . $sdk_version;
    //前2个偶数，后两个奇数，并到一起4个，再反转4个，一共8个倒序排序，共16个
    var_dump($token);
    var_dump(str_split($token, 1));
    $str_arr = str_split($token, 1);
    $odd_arr = $even_arr = array();
    foreach ($str_arr as $value) {
        if (is_odd($value)) {
            $odd_arr[$value] = $value;
        } else if (is_even($value)) {
            $even_arr[$value] = $value;
        }
    }
    //偶数是否多于2个，是则取前2个，否则用8填充
    //奇数是否多于2个，是则取前2个，否则用9填充
    $first_2_odd = getNum($odd_arr, 2, 8);
    $first_2_even = getNum($even_arr, 2, 9);
    
    //奇偶合并4个, 偶数在前，奇数在后
    $combine_1_arr = array_merge($first_2_even, $first_2_odd);
    //翻转合并的4个，得到新的4个
    $reverse_combine_1_arr = array_reverse($combine_1_arr);
    //合并两个4,得到8个
    $combine_2_arr = array_merge($reverse_combine_1_arr,$combine_1_arr);
    //8个再倒序排序
    $order_combine_2_arr = $combine_2_arr;
    rsort($order_combine_2_arr);
    //合并得到16个
    $combine_3_arr = array_merge($combine_2_arr,$order_combine_2_arr);
    $secret_key = implode("", $combine_3_arr);
//    var_dump($secret_key);die;
    return $secret_key;
    
    
//    var_dump($combine_3_arr);
//    var_dump($order_combine_2_arr);
//    var_dump($combine_2_arr);
//    var_dump($reverse_combine_1_arr);
//    var_dump($combine_1_arr);
//    var_dump($first_2_odd);
//    var_dump($first_2_even);
//    var_dump($odd_arr);
//    var_dump($even_arr);
//    $end = microtime();
//    echo "use microseconds: <br>";
//    echo $end - $start;
//    die;
}

/**
 * 获取一个数组的前X个值
 * 如果数组不够长，以默认值填充
 * @param type $arr
 * @param type $length
 * @param type $default_num
 * @return type
 */
function getNum($arr,$length,$default_num){
    $cnt = count($arr);
    $ret = array();
    if($cnt >= $length){
        $ret = array_slice($arr, 0,$length);
    }else{
        for($i = 0; $i < ($length - $cnt); $i++){
            $arr[] = $default_num;
        }
        $ret = $arr;
    }
    return $ret;
}
//判断奇数，是返回TRUE，否返回FALSE
function is_odd($num) {
    return (is_numeric($num) & ($num & 1));
}

//判断偶数，是返回TRUE，否返回FALSE
function is_even($num) {
    return (is_numeric($num) & (!($num & 1)));
}

$sec = genSK("1.2.1");
$aes = new AES($sec);
$start = microtime(true);
$data = "删掉了积分了世纪东方老实交代反链是极度分裂删掉了积分了世纪东方老实交代反链是极度分裂删掉了积分了世纪东方老实交代反链是极度分裂删掉了积分了世纪东方老实交代反链是极度分裂删掉了积分了世纪东方老实交代反链是极度分裂删掉了积分了世纪东方老实交代反链是极度分裂删掉了积分了世纪东方老实交代反链是极度分裂删掉了积分了世纪东方老实交代反链是极度分裂删掉了积分了世纪东方老实交代反链是极度分裂删掉了积分了世纪东方老实交代反链是极度分裂删掉了积分了世纪东方老实交代反链是极度分裂删掉了积分了世纪东方老实交代反链是极度分裂删掉了积分了世纪东方老实交代反链是极度分裂删掉了积分了世纪东方老实交代反链是极度分裂删掉了积分了世纪东方老实交代反链是极度分裂删掉了积分了世纪东方老实交代反链是极度分裂删掉了积分了世纪东方老实交代反链是极度分裂删掉了积分了世纪东方老实交代反链是极度分裂删掉了积分了世纪东方老实交代反链是极度分裂";
$encrypt = $aes->encrypt($data);
echo "\n\nCipher-Text:\n" . $encrypt . "\n";
echo "\n\nPlain-Text:\n" . $aes->decrypt($encrypt) . "\n";
$end = microtime(true);

echo "\n\nExecution time: " . ($end - $start);
die;
