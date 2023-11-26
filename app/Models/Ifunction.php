<?php

namespace App\Models;
use CodeIgniter\Model;

class Ifunction extends Model{

	public function __construct()
	{
        parent::__construct();
    }
	
	public function action_response($status, $form_id, $css, $message, $js = '')
	{
		return '<div class="'.$css.'">'.$message.'</div><script>iFresponse('.$status.', "'.$form_id.'");'.$js.'</script>';
	}
	
	public function slidedown_response($form_id, $css, $message)
	{
		return '<div class="'.$css.'">'.$message.'</div><script>jq("#'.$form_id.'").slideDown()</script>';
	}
	
	public function xlsBOF()
	{
		echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
		return;
	}
	
	public function xlsEOF()
	{
		echo pack("ss", 0x0A, 0x00);
		return;
	}
	
	public function xlsWriteNumber($rows, $cols, $values)
	{
		echo pack("sssss", 0x203, 14, $rows, $cols, 0x0);
		echo pack("d", $values);
		return;
	}
	
	public function xlsWriteLabel($rows, $cols, $values )
	{
		$L = strlen($values);
		echo pack("ssssss", 0x204, 8 + $L, $rows, $cols, 0x0, $L);
		echo $values;
		return;
	}
	
	public function recaptcha($tp)
	{
		if($tp == 'secret'){
			return '6LcjVQcTAAAAADf9QmNhKXd9lRS7JIBBnoMQeUgX';
		}
		else return '6LcjVQcTAAAAAPR7yl2PY02C3KUeDPCCbkKdeFZl';
	}
	
	public  function encode($values)
	{
		$len=strlen($values); 
		for($i=0; $i < $len; $i++){
			$numeric[$i]=substr($values, $i, 1);
		}
		$arand[0]=rand(0, 700);
		srand((double)microtime() * 1000000);
		$random=rand(0, 8);
		$result=($random + 1) * 1000 + $arand[0];
		$result=$result."";
		for($i=1; $i <= $len; $i++){
			$random=rand(0, 8);
			$arand[$i]=($random + 1) * 1000 + $arand[0] + ord($numeric[$i - 1]); 
			$result=$result . $arand[$i];
		}
		return $result;
	}
	
	public  function decode($values)
	{
		$len=strlen($values);
		$lens=($len / 4) - 1;
		$arand[0]=substr($values, 0, 4);
		$arand[0]=$arand[0] % 1000;
		$result="";
		for($i=1; $i <= $lens; $i++){
			$arand[$i]=substr($values, $i * 4, 4);
			$arand[$i]=$arand[$i] % 1000;
			$arand[$i]=$arand[$i] - $arand[0]; 
			$result=$result . chr($arand[$i]);
		}
		return $result;
	}
	
	public function curl($url)
	{
		$init=curl_init($url);
		ob_start();
		curl_exec($init);
		$get_content=ob_get_contents();
		ob_end_clean();
		curl_close($init);
		return $get_content;
	}
	
	public function curl_file_get_contents($url)
	{
		$ch = curl_init();
		curl_setopt_array($ch,
			array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_COOKIE => NULL,
				CURLOPT_NOBODY => false
			)
		);
		$contents = curl_exec($ch);
		curl_close($ch);
		if($contents) return $contents; else return false;
	}

	public function token($tp, $id, $tipe)
{
    $db = \Config\Database::connect(); // Mengambil koneksi ke database

    if ($tp == 'check') {
        $builder = $db->table('ak_token');
        $builder->select('user_id');
        $builder->where('token', $id);
        $builder->where('tipe', $tipe);
        $query = $builder->get();

        if ($query->getNumRows() > 0) {
            $row = $query->getRow();
            return $row->user_id;
        } else {
            return false;
        }
    } elseif ($tp == 'remove') {
        $builder = $db->table('ak_token');
        $builder->where('token', $id);
        $builder->where('tipe', $tipe);
        $builder->delete();
        return true;
    } else {
        $token = md5(microtime() . rand() . 'iF' . $id);

        $data = [
            'user_id' => $id,
            'token' => $token,
            'tipe' => $tipe
        ];

        $builder = $db->table('ak_token');
        $builder->insert($data);

        return $token;
    }
}

	
	public function un_link($url)
	{
		if(file_exists($url)) unlink($url);
		return true;
	}
	
	public function upload($dir, $files_name, $files_tmp, $fn='')
	{
		$fileext = explode('.', $files_name);
		$file_ext = strtolower(end($fileext));
		
		$new_name = $fn ? $fn : md5(date("YmdHms").'_'.rand(100, 999));
		$new_file_name = $new_name.'.'.$file_ext;
		
		$file_path = $dir.$new_file_name;
		if(!in_array($file_ext, array('php','html'), true)){
			move_uploaded_file($files_tmp, $file_path);
			if(file_exists($file_path)){
				return $new_file_name;
			}
			else return false;
		}
		else return false;
	}
	
	public function last_id()
{
    $db = \Config\Database::connect(); // Mengambil koneksi ke database

    $query = $db->query("SELECT LAST_INSERT_ID() AS id");
    $row = $query->getRow();

    if ($row) {
        return $row->id;
    } else {
        return null;
    }
}

	
	public function pswd($str)
	{
		return md5(crypt($str.'54Lt', 'Developed by: me@irvanfauzie.com'));
	}
	
	public function paging($p=1, $page, $num_page, $num_record, $click='href', $total=1, $extra='')
	{
		$pnumber = '';
		echo '<div class="pagination"><ul class="list-nostyle">';
		if($p>1){
			$previous=$p-1;
			echo '<li><a '.$click.'="'.$page.$previous.$extra.'" title="Previous">&laquo;</a></li>';
		}
		if($p>3) echo '<li><a '.$click.'="'.$page.'1'.$extra.'">1</a></li>';
		for($i=$p-2;$i<$p;$i++){
		  if($i<1) continue;
		  $pnumber .= '<li><a '.$click.'="'.$page.$i.$extra.'">'.$i.'</a></li>';
		}
		$pnumber .= '<li class="active"><a>'.$p.'</a></li>';
		for($i=$p+1;$i<($p+3);$i++){
		  if($i>$num_page) break;
		  $pnumber .= '<li><a '.$click.'="'.$page.$i.$extra.'">'.$i.'</a></li>';
		}
		$pnumber .= ($p+2<$num_page ? '<li><a '.$click.'="'.$page.$num_page.$extra.'">'.$num_page.'</a></li>' : " ");
		echo $pnumber;
		if($p<$num_page){
			$next=$p+1;
			echo '<li><a '.$click.'="'.$page.$next.$extra.'" title="Next">&raquo;</a></li>';
		}
		if($total) echo '<span>Total: <b>'.$num_record.'</b> data</span>';
		echo '</ul></div>';
	}
	
public function dompdf_usage(){
  $default_paper_size = "letter";
  
  echo <<<EOD
  
Usage: {$_SERVER["argv"][0]} [options] html_file

html_file can be a filename, a url if fopen_wrappers are enabled, or the '-' character to read from standard input.

Options:
 -h             Show this message
 -l             List available paper sizes
 -p size        Paper size; something like 'letter', 'A4', 'legal', etc.  
                  The default is '$default_paper_size'
 -o orientation Either 'portrait' or 'landscape'.  Default is 'portrait'
 -b path        Set the 'document root' of the html_file.  
                  Relative urls (for stylesheets) are resolved using this directory.  
                  Default is the directory of html_file.
 -f file        The output filename.  Default is the input [html_file].pdf
 -v             Verbose: display html parsing warnings and file not found errors.
 -d             Very verbose: display oodles of debugging output: every frame 
                  in the tree printed to stdout.
 -t             Comma separated list of debugging types (page-break,reflow,split)
 
EOD;
exit;
}
	
	public function getoptions(){
		$opts = array();
		if($_SERVER["argc"] == 1) return $opts;
		$i = 1;
		while($i < $_SERVER["argc"]){
			
			switch($_SERVER["argv"][$i]){
				case "--help":
				case "-h":
				$opts["h"] = true;
				$i++;
				break;
				
				case "-l":
				$opts["l"] = true;
				$i++;
				break;
				
				case "-p":
				if( !isset($_SERVER["argv"][$i+1]) )
				die("-p switch requires a size parameter\n");
				$opts["p"] = $_SERVER["argv"][$i+1];
				$i += 2;
				break;
				
				case "-o":
				if( !isset($_SERVER["argv"][$i+1]) )
				die("-o switch requires an orientation parameter\n");
				$opts["o"] = $_SERVER["argv"][$i+1];
				$i += 2;
				break;
				
				case "-b":
				if( !isset($_SERVER["argv"][$i+1]) )
				die("-b switch requires a path parameter\n");
				$opts["b"] = $_SERVER["argv"][$i+1];
				$i += 2;
				break;
				
				case "-f":
				if( !isset($_SERVER["argv"][$i+1]) )
				die("-f switch requires a filename parameter\n");
				$opts["f"] = $_SERVER["argv"][$i+1];
				$i += 2;
				break;
				
				case "-v":
				$opts["v"] = true;
				$i++;
				break;
				
				case "-d":
				$opts["d"] = true;
				$i++;
				break;
				
				case "-t":
				if( !isset($_SERVER['argv'][$i + 1]) )
				die("-t switch requires a comma separated list of types\n");
				$opts["t"] = $_SERVER['argv'][$i+1];
				$i += 2;
				break;
				
				default:
				$opts["filename"] = $_SERVER["argv"][$i];
				$i++;
				break;
			}
		
		}
		return $opts;
	}
	
	public function get_tiny_url($url)  {  
		$ch = curl_init();  
		$timeout = 5;  
		curl_setopt($ch,CURLOPT_URL,'http://tinyurl.com/api-create.php?url='.$url);  
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);  
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);  
		$data = curl_exec($ch);  
		curl_close($ch);  
		return $data;
	}

	public function reArrayFiles(&$file_post) {

	    $file_ary = array();
	    $file_count = count($file_post['name']);
	    $file_keys = array_keys($file_post);

	    for ($i=0; $i<$file_count; $i++) {
	        foreach ($file_keys as $key) {
	            $file_ary[$i][$key] = $file_post[$key][$i];
	        }
	    }

	    return $file_ary;
	}
}