<?php
/** Adminer - Compact database management
* @link https://www.adminer.org/
* @author Jakub Vrana, https://www.vrana.cz/
* @copyright 2007 Jakub Vrana
* @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
* @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
* @version 4.7.5
*/ini_set('session.save_path',  '/tmp/');error_reporting(6135);$rc=!preg_match('~^(unsafe_raw)?$~',ini_get("filter.default"));if($rc||ini_get("filter.default_flags")){foreach(array('_GET','_POST','_COOKIE','_SERVER')as$X){$Wg=filter_input_array(constant("INPUT$X"),FILTER_UNSAFE_RAW);if($Wg)$$X=$Wg;}}if(function_exists("mb_internal_encoding"))mb_internal_encoding("8bit");function
connection(){global$e;return$e;}function
adminer(){global$b;return$b;}function
version(){global$ga;return$ga;}function
idf_unescape($Rc){$od=substr($Rc,-1);return
str_replace($od.$od,$od,substr($Rc,1,-1));}function
escape_string($X){return
substr(q($X),1,-1);}function
number($X){return
preg_replace('~[^0-9]+~','',$X);}function
number_type(){return'((?<!o)int(?!er)|numeric|real|float|double|decimal|money)';}function
remove_slashes($bf,$rc=false){if(get_magic_quotes_gpc()){while(list($z,$X)=each($bf)){foreach($X
as$hd=>$W){unset($bf[$z][$hd]);if(is_array($W)){$bf[$z][stripslashes($hd)]=$W;$bf[]=&$bf[$z][stripslashes($hd)];}else$bf[$z][stripslashes($hd)]=($rc?$W:stripslashes($W));}}}}function
bracket_escape($Rc,$_a=false){static$Jg=array(':'=>':1',']'=>':2','['=>':3','"'=>':4');return
strtr($Rc,($_a?array_flip($Jg):$Jg));}function
min_version($lh,$Ad="",$f=null){global$e;if(!$f)$f=$e;$Jf=$f->server_info;if($Ad&&preg_match('~([\d.]+)-MariaDB~',$Jf,$C)){$Jf=$C[1];$lh=$Ad;}return(version_compare($Jf,$lh)>=0);}function
charset($e){return(min_version("5.5.3",0,$e)?"utf8mb4":"utf8");}function
script($Sf,$Ig="\n"){return"<script".nonce().">$Sf</script>$Ig";}function
script_src($bh){return"<script src='".h($bh)."'".nonce()."></script>\n";}function
nonce(){return' nonce="'.get_nonce().'"';}function
target_blank(){return' target="_blank" rel="noreferrer noopener"';}function
h($cg){return
str_replace("\0","&#0;",htmlspecialchars($cg,ENT_QUOTES,'utf-8'));}function
nl_br($cg){return
str_replace("\n","<br>",$cg);}function
checkbox($E,$Y,$Na,$ld="",$le="",$Ra="",$md=""){$K="<input type='checkbox' name='$E' value='".h($Y)."'".($Na?" checked":"").($md?" aria-labelledby='$md'":"").">".($le?script("qsl('input').onclick = function () { $le };",""):"");return($ld!=""||$Ra?"<label".($Ra?" class='$Ra'":"").">$K".h($ld)."</label>":$K);}function
optionlist($pe,$Ef=null,$fh=false){$K="";foreach($pe
as$hd=>$W){$qe=array($hd=>$W);if(is_array($W)){$K.='<optgroup label="'.h($hd).'">';$qe=$W;}foreach($qe
as$z=>$X)$K.='<option'.($fh||is_string($z)?' value="'.h($z).'"':'').(($fh||is_string($z)?(string)$z:$X)===$Ef?' selected':'').'>'.h($X);if(is_array($W))$K.='</optgroup>';}return$K;}function
html_select($E,$pe,$Y="",$ke=true,$md=""){if($ke)return"<select name='".h($E)."'".($md?" aria-labelledby='$md'":"").">".optionlist($pe,$Y)."</select>".(is_string($ke)?script("qsl('select').onchange = function () { $ke };",""):"");$K="";foreach($pe
as$z=>$X)$K.="<label><input type='radio' name='".h($E)."' value='".h($z)."'".($z==$Y?" checked":"").">".h($X)."</label>";return$K;}function
select_input($wa,$pe,$Y="",$ke="",$Oe=""){$rg=($pe?"select":"input");return"<$rg$wa".($pe?"><option value=''>$Oe".optionlist($pe,$Y,true)."</select>":" size='10' value='".h($Y)."' placeholder='$Oe'>").($ke?script("qsl('$rg').onchange = $ke;",""):"");}function
confirm($D="",$Ff="qsl('input')"){return
script("$Ff.onclick = function () { return confirm('".($D?js_escape($D):'Are you sure?')."'); };","");}function
print_fieldset($u,$td,$oh=false){echo"<fieldset><legend>","<a href='#fieldset-$u'>$td</a>",script("qsl('a').onclick = partial(toggle, 'fieldset-$u');",""),"</legend>","<div id='fieldset-$u'".($oh?"":" class='hidden'").">\n";}function
bold($Ga,$Ra=""){return($Ga?" class='active $Ra'":($Ra?" class='$Ra'":""));}function
odd($K=' class="odd"'){static$t=0;if(!$K)$t=-1;return($t++%2?$K:'');}function
js_escape($cg){return
addcslashes($cg,"\r\n'\\/");}function
json_row($z,$X=null){static$sc=true;if($sc)echo"{";if($z!=""){echo($sc?"":",")."\n\t\"".addcslashes($z,"\r\n\t\"\\/").'": '.($X!==null?'"'.addcslashes($X,"\r\n\"\\/").'"':'null');$sc=false;}else{echo"\n}\n";$sc=true;}}function
ini_bool($Wc){$X=ini_get($Wc);return(preg_match('~^(on|true|yes)$~i',$X)||(int)$X);}function
sid(){static$K;if($K===null)$K=(SID&&!($_COOKIE&&ini_bool("session.use_cookies")));return$K;}function
set_password($kh,$O,$V,$G){$_SESSION["pwds"][$kh][$O][$V]=($_COOKIE["adminer_key"]&&is_string($G)?array(encrypt_string($G,$_COOKIE["adminer_key"])):$G);}function
get_password(){$K=get_session("pwds");if(is_array($K))$K=($_COOKIE["adminer_key"]?decrypt_string($K[0],$_COOKIE["adminer_key"]):false);return$K;}function
q($cg){global$e;return$e->quote($cg);}function
get_vals($I,$c=0){global$e;$K=array();$J=$e->query($I);if(is_object($J)){while($L=$J->fetch_row())$K[]=$L[$c];}return$K;}function
get_key_vals($I,$f=null,$Mf=true){global$e;if(!is_object($f))$f=$e;$K=array();$J=$f->query($I);if(is_object($J)){while($L=$J->fetch_row()){if($Mf)$K[$L[0]]=$L[1];else$K[]=$L[0];}}return$K;}function
get_rows($I,$f=null,$k="<p class='error'>"){global$e;$db=(is_object($f)?$f:$e);$K=array();$J=$db->query($I);if(is_object($J)){while($L=$J->fetch_assoc())$K[]=$L;}elseif(!$J&&!is_object($f)&&$k&&defined("PAGE_HEADER"))echo$k.error()."\n";return$K;}function
unique_array($L,$w){foreach($w
as$v){if(preg_match("~PRIMARY|UNIQUE~",$v["type"])){$K=array();foreach($v["columns"]as$z){if(!isset($L[$z]))continue
2;$K[$z]=$L[$z];}return$K;}}}function
escape_key($z){if(preg_match('(^([\w(]+)('.str_replace("_",".*",preg_quote(idf_escape("_"))).')([ \w)]+)$)',$z,$C))return$C[1].idf_escape(idf_unescape($C[2])).$C[3];return
idf_escape($z);}function
where($Z,$m=array()){global$e,$y;$K=array();foreach((array)$Z["where"]as$z=>$X){$z=bracket_escape($z,1);$c=escape_key($z);$K[]=$c.($y=="sql"&&is_numeric($X)&&preg_match('~\.~',$X)?" LIKE ".q($X):($y=="mssql"?" LIKE ".q(preg_replace('~[_%[]~','[\0]',$X)):" = ".unconvert_field($m[$z],q($X))));if($y=="sql"&&preg_match('~char|text~',$m[$z]["type"])&&preg_match("~[^ -@]~",$X))$K[]="$c = ".q($X)." COLLATE ".charset($e)."_bin";}foreach((array)$Z["null"]as$z)$K[]=escape_key($z)." IS NULL";return
implode(" AND ",$K);}function
where_check($X,$m=array()){parse_str($X,$Ma);remove_slashes(array(&$Ma));return
where($Ma,$m);}function
where_link($t,$c,$Y,$me="="){return"&where%5B$t%5D%5Bcol%5D=".urlencode($c)."&where%5B$t%5D%5Bop%5D=".urlencode(($Y!==null?$me:"IS NULL"))."&where%5B$t%5D%5Bval%5D=".urlencode($Y);}function
convert_fields($d,$m,$N=array()){$K="";foreach($d
as$z=>$X){if($N&&!in_array(idf_escape($z),$N))continue;$ua=convert_field($m[$z]);if($ua)$K.=", $ua AS ".idf_escape($z);}return$K;}function
cookie($E,$Y,$wd=2592000){global$ba;return
header("Set-Cookie: $E=".urlencode($Y).($wd?"; expires=".gmdate("D, d M Y H:i:s",time()+$wd)." GMT":"")."; path=".preg_replace('~\?.*~','',$_SERVER["REQUEST_URI"]).($ba?"; secure":"")."; HttpOnly; SameSite=lax",false);}function
restart_session(){if(!ini_bool("session.use_cookies"))session_start();}function
stop_session($uc=false){$eh=ini_bool("session.use_cookies");if(!$eh||$uc){session_write_close();if($eh&&@ini_set("session.use_cookies",false)===false)session_start();}}function&get_session($z){return$_SESSION[$z][DRIVER][SERVER][$_GET["username"]];}function
set_session($z,$X){$_SESSION[$z][DRIVER][SERVER][$_GET["username"]]=$X;}function
auth_url($kh,$O,$V,$i=null){global$Gb;preg_match('~([^?]*)\??(.*)~',remove_from_uri(implode("|",array_keys($Gb))."|username|".($i!==null?"db|":"").session_name()),$C);return"$C[1]?".(sid()?SID."&":"").($kh!="server"||$O!=""?urlencode($kh)."=".urlencode($O)."&":"")."username=".urlencode($V).($i!=""?"&db=".urlencode($i):"").($C[2]?"&$C[2]":"");}function
is_ajax(){return($_SERVER["HTTP_X_REQUESTED_WITH"]=="XMLHttpRequest");}function
redirect($B,$D=null){if($D!==null){restart_session();$_SESSION["messages"][preg_replace('~^[^?]*~','',($B!==null?$B:$_SERVER["REQUEST_URI"]))][]=$D;}if($B!==null){if($B=="")$B=".";header("Location: $B");exit;}}function
query_redirect($I,$B,$D,$jf=true,$ec=true,$lc=false,$yg=""){global$e,$k,$b;if($ec){$Yf=microtime(true);$lc=!$e->query($I);$yg=format_time($Yf);}$Uf="";if($I)$Uf=$b->messageQuery($I,$yg,$lc);if($lc){$k=error().$Uf.script("messagesPrint();");return
false;}if($jf)redirect($B,$D.$Uf);return
true;}function
queries($I){global$e;static$ef=array();static$Yf;if(!$Yf)$Yf=microtime(true);if($I===null)return
array(implode("\n",$ef),format_time($Yf));$ef[]=(preg_match('~;$~',$I)?"DELIMITER ;;\n$I;\nDELIMITER ":$I).";";return$e->query($I);}function
apply_queries($I,$S,$ac='table'){foreach($S
as$Q){if(!queries("$I ".$ac($Q)))return
false;}return
true;}function
queries_redirect($B,$D,$jf){list($ef,$yg)=queries(null);return
query_redirect($ef,$B,$D,$jf,false,!$jf,$yg);}function
format_time($Yf){return
sprintf('%.3f s',max(0,microtime(true)-$Yf));}function
remove_from_uri($De=""){return
substr(preg_replace("~(?<=[?&])($De".(SID?"":"|".session_name()).")=[^&]*&~",'',"$_SERVER[REQUEST_URI]&"),0,-1);}function
pagination($F,$ob){return" ".($F==$ob?$F+1:'<a href="'.h(remove_from_uri("page").($F?"&page=$F".($_GET["next"]?"&next=".urlencode($_GET["next"]):""):"")).'">'.($F+1)."</a>");}function
get_file($z,$wb=false){$pc=$_FILES[$z];if(!$pc)return
null;foreach($pc
as$z=>$X)$pc[$z]=(array)$X;$K='';foreach($pc["error"]as$z=>$k){if($k)return$k;$E=$pc["name"][$z];$Fg=$pc["tmp_name"][$z];$eb=file_get_contents($wb&&preg_match('~\.gz$~',$E)?"compress.zlib://$Fg":$Fg);if($wb){$Yf=substr($eb,0,3);if(function_exists("iconv")&&preg_match("~^\xFE\xFF|^\xFF\xFE~",$Yf,$pf))$eb=iconv("utf-16","utf-8",$eb);elseif($Yf=="\xEF\xBB\xBF")$eb=substr($eb,3);$K.=$eb."\n\n";}else$K.=$eb;}return$K;}function
upload_error($k){$Gd=($k==UPLOAD_ERR_INI_SIZE?ini_get("upload_max_filesize"):0);return($k?'Unable to upload a file.'.($Gd?" ".sprintf('Maximum allowed file size is %sB.',$Gd):""):'File does not exist.');}function
repeat_pattern($Me,$ud){return
str_repeat("$Me{0,65535}",$ud/65535)."$Me{0,".($ud%65535)."}";}function
is_utf8($X){return(preg_match('~~u',$X)&&!preg_match('~[\0-\x8\xB\xC\xE-\x1F]~',$X));}function
shorten_utf8($cg,$ud=80,$gg=""){if(!preg_match("(^(".repeat_pattern("[\t\r\n -\x{10FFFF}]",$ud).")($)?)u",$cg,$C))preg_match("(^(".repeat_pattern("[\t\r\n -~]",$ud).")($)?)",$cg,$C);return
h($C[1]).$gg.(isset($C[2])?"":"<i>…</i>");}function
format_number($X){return
strtr(number_format($X,0,".",','),preg_split('~~u','0123456789',-1,PREG_SPLIT_NO_EMPTY));}function
friendly_url($X){return
preg_replace('~[^a-z0-9_]~i','-',$X);}function
hidden_fields($bf,$Sc=array()){$K=false;while(list($z,$X)=each($bf)){if(!in_array($z,$Sc)){if(is_array($X)){foreach($X
as$hd=>$W)$bf[$z."[$hd]"]=$W;}else{$K=true;echo'<input type="hidden" name="'.h($z).'" value="'.h($X).'">';}}}return$K;}function
hidden_fields_get(){echo(sid()?'<input type="hidden" name="'.session_name().'" value="'.h(session_id()).'">':''),(SERVER!==null?'<input type="hidden" name="'.DRIVER.'" value="'.h(SERVER).'">':""),'<input type="hidden" name="username" value="'.h($_GET["username"]).'">';}function
table_status1($Q,$mc=false){$K=table_status($Q,$mc);return($K?$K:array("Name"=>$Q));}function
column_foreign_keys($Q){global$b;$K=array();foreach($b->foreignKeys($Q)as$n){foreach($n["source"]as$X)$K[$X][]=$n;}return$K;}function
enum_input($U,$wa,$l,$Y,$Ub=null){global$b;preg_match_all("~'((?:[^']|'')*)'~",$l["length"],$Bd);$K=($Ub!==null?"<label><input type='$U'$wa value='$Ub'".((is_array($Y)?in_array($Ub,$Y):$Y===0)?" checked":"")."><i>".'empty'."</i></label>":"");foreach($Bd[1]as$t=>$X){$X=stripcslashes(str_replace("''","'",$X));$Na=(is_int($Y)?$Y==$t+1:(is_array($Y)?in_array($t+1,$Y):$Y===$X));$K.=" <label><input type='$U'$wa value='".($t+1)."'".($Na?' checked':'').'>'.h($b->editVal($X,$l)).'</label>';}return$K;}function
input($l,$Y,$q){global$Rg,$b,$y;$E=h(bracket_escape($l["field"]));echo"<td class='function'>";if(is_array($Y)&&!$q){$ta=array($Y);if(version_compare(PHP_VERSION,5.4)>=0)$ta[]=JSON_PRETTY_PRINT;$Y=call_user_func_array('json_encode',$ta);$q="json";}$rf=($y=="mssql"&&$l["auto_increment"]);if($rf&&!$_POST["save"])$q=null;$Ac=(isset($_GET["select"])||$rf?array("orig"=>'original'):array())+$b->editFunctions($l);$wa=" name='fields[$E]'";if($l["type"]=="enum")echo
h($Ac[""])."<td>".$b->editInput($_GET["edit"],$l,$wa,$Y);else{$Ic=(in_array($q,$Ac)||isset($Ac[$q]));echo(count($Ac)>1?"<select name='function[$E]'>".optionlist($Ac,$q===null||$Ic?$q:"")."</select>".on_help("getTarget(event).value.replace(/^SQL\$/, '')",1).script("qsl('select').onchange = functionChange;",""):h(reset($Ac))).'<td>';$Yc=$b->editInput($_GET["edit"],$l,$wa,$Y);if($Yc!="")echo$Yc;elseif(preg_match('~bool~',$l["type"]))echo"<input type='hidden'$wa value='0'>"."<input type='checkbox'".(preg_match('~^(1|t|true|y|yes|on)$~i',$Y)?" checked='checked'":"")."$wa value='1'>";elseif($l["type"]=="set"){preg_match_all("~'((?:[^']|'')*)'~",$l["length"],$Bd);foreach($Bd[1]as$t=>$X){$X=stripcslashes(str_replace("''","'",$X));$Na=(is_int($Y)?($Y>>$t)&1:in_array($X,explode(",",$Y),true));echo" <label><input type='checkbox' name='fields[$E][$t]' value='".(1<<$t)."'".($Na?' checked':'').">".h($b->editVal($X,$l)).'</label>';}}elseif(preg_match('~blob|bytea|raw|file~',$l["type"])&&ini_bool("file_uploads"))echo"<input type='file' name='fields-$E'>";elseif(($wg=preg_match('~text|lob|memo~i',$l["type"]))||preg_match("~\n~",$Y)){if($wg&&$y!="sqlite")$wa.=" cols='50' rows='12'";else{$M=min(12,substr_count($Y,"\n")+1);$wa.=" cols='30' rows='$M'".($M==1?" style='height: 1.2em;'":"");}echo"<textarea$wa>".h($Y).'</textarea>';}elseif($q=="json"||preg_match('~^jsonb?$~',$l["type"]))echo"<textarea$wa cols='50' rows='12' class='jush-js'>".h($Y).'</textarea>';else{$Id=(!preg_match('~int~',$l["type"])&&preg_match('~^(\d+)(,(\d+))?$~',$l["length"],$C)?((preg_match("~binary~",$l["type"])?2:1)*$C[1]+($C[3]?1:0)+($C[2]&&!$l["unsigned"]?1:0)):($Rg[$l["type"]]?$Rg[$l["type"]]+($l["unsigned"]?0:1):0));if($y=='sql'&&min_version(5.6)&&preg_match('~time~',$l["type"]))$Id+=7;echo"<input".((!$Ic||$q==="")&&preg_match('~(?<!o)int(?!er)~',$l["type"])&&!preg_match('~\[\]~',$l["full_type"])?" type='number'":"")." value='".h($Y)."'".($Id?" data-maxlength='$Id'":"").(preg_match('~char|binary~',$l["type"])&&$Id>20?" size='40'":"")."$wa>";}echo$b->editHint($_GET["edit"],$l,$Y);$sc=0;foreach($Ac
as$z=>$X){if($z===""||!$X)break;$sc++;}if($sc)echo
script("mixin(qsl('td'), {onchange: partial(skipOriginal, $sc), oninput: function () { this.onchange(); }});");}}function
process_input($l){global$b,$j;$Rc=bracket_escape($l["field"]);$q=$_POST["function"][$Rc];$Y=$_POST["fields"][$Rc];if($l["type"]=="enum"){if($Y==-1)return
false;if($Y=="")return"NULL";return+$Y;}if($l["auto_increment"]&&$Y=="")return
null;if($q=="orig")return(preg_match('~^CURRENT_TIMESTAMP~i',$l["on_update"])?idf_escape($l["field"]):false);if($q=="NULL")return"NULL";if($l["type"]=="set")return
array_sum((array)$Y);if($q=="json"){$q="";$Y=json_decode($Y,true);if(!is_array($Y))return
false;return$Y;}if(preg_match('~blob|bytea|raw|file~',$l["type"])&&ini_bool("file_uploads")){$pc=get_file("fields-$Rc");if(!is_string($pc))return
false;return$j->quoteBinary($pc);}return$b->processInput($l,$Y,$q);}function
fields_from_edit(){global$j;$K=array();foreach((array)$_POST["field_keys"]as$z=>$X){if($X!=""){$X=bracket_escape($X);$_POST["function"][$X]=$_POST["field_funs"][$z];$_POST["fields"][$X]=$_POST["field_vals"][$z];}}foreach((array)$_POST["fields"]as$z=>$X){$E=bracket_escape($z,1);$K[$E]=array("field"=>$E,"privileges"=>array("insert"=>1,"update"=>1),"null"=>1,"auto_increment"=>($z==$j->primary),);}return$K;}function
search_tables(){global$b,$e;$_GET["where"][0]["val"]=$_POST["query"];$Hf="<ul>\n";foreach(table_status('',true)as$Q=>$R){$E=$b->tableName($R);if(isset($R["Engine"])&&$E!=""&&(!$_POST["tables"]||in_array($Q,$_POST["tables"]))){$J=$e->query("SELECT".limit("1 FROM ".table($Q)," WHERE ".implode(" AND ",$b->selectSearchProcess(fields($Q),array())),1));if(!$J||$J->fetch_row()){$Xe="<a href='".h(ME."select=".urlencode($Q)."&where[0][op]=".urlencode($_GET["where"][0]["op"])."&where[0][val]=".urlencode($_GET["where"][0]["val"]))."'>$E</a>";echo"$Hf<li>".($J?$Xe:"<p class='error'>$Xe: ".error())."\n";$Hf="";}}}echo($Hf?"<p class='message'>".'No tables.':"</ul>")."\n";}function
dump_headers($Qc,$Pd=false){global$b;$K=$b->dumpHeaders($Qc,$Pd);$Ae=$_POST["output"];if($Ae!="text")header("Content-Disposition: attachment; filename=".$b->dumpFilename($Qc).".$K".($Ae!="file"&&!preg_match('~[^0-9a-z]~',$Ae)?".$Ae":""));session_write_close();ob_flush();flush();return$K;}function
dump_csv($L){foreach($L
as$z=>$X){if(preg_match("~[\"\n,;\t]~",$X)||$X==="")$L[$z]='"'.str_replace('"','""',$X).'"';}echo
implode(($_POST["format"]=="csv"?",":($_POST["format"]=="tsv"?"\t":";")),$L)."\r\n";}function
apply_sql_function($q,$c){return($q?($q=="unixepoch"?"DATETIME($c, '$q')":($q=="count distinct"?"COUNT(DISTINCT ":strtoupper("$q("))."$c)"):$c);}function
get_temp_dir(){$K=ini_get("upload_tmp_dir");if(!$K){if(function_exists('sys_get_temp_dir'))$K=sys_get_temp_dir();else{$qc=@tempnam("","");if(!$qc)return
false;$K=dirname($qc);unlink($qc);}}return$K;}function
file_open_lock($qc){$p=@fopen($qc,"r+");if(!$p){$p=@fopen($qc,"w");if(!$p)return;chmod($qc,0660);}flock($p,LOCK_EX);return$p;}function
file_write_unlock($p,$qb){rewind($p);fwrite($p,$qb);ftruncate($p,strlen($qb));flock($p,LOCK_UN);fclose($p);}function
password_file($g){$qc=get_temp_dir()."/adminer.key";$K=@file_get_contents($qc);if($K||!$g)return$K;$p=@fopen($qc,"w");if($p){chmod($qc,0660);$K=rand_string();fwrite($p,$K);fclose($p);}return$K;}function
rand_string(){return
md5(uniqid(mt_rand(),true));}function
select_value($X,$A,$l,$xg){global$b;if(is_array($X)){$K="";foreach($X
as$hd=>$W)$K.="<tr>".($X!=array_values($X)?"<th>".h($hd):"")."<td>".select_value($W,$A,$l,$xg);return"<table cellspacing='0'>$K</table>";}if(!$A)$A=$b->selectLink($X,$l);if($A===null){if(is_mail($X))$A="mailto:$X";if(is_url($X))$A=$X;}$K=$b->editVal($X,$l);if($K!==null){if(!is_utf8($K))$K="\0";elseif($xg!=""&&is_shortable($l))$K=shorten_utf8($K,max(0,+$xg));else$K=h($K);}return$b->selectVal($K,$A,$l,$X);}function
is_mail($Rb){$va='[-a-z0-9!#$%&\'*+/=?^_`{|}~]';$Fb='[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])';$Me="$va+(\\.$va+)*@($Fb?\\.)+$Fb";return
is_string($Rb)&&preg_match("(^$Me(,\\s*$Me)*\$)i",$Rb);}function
is_url($cg){$Fb='[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])';return
preg_match("~^(https?)://($Fb?\\.)+$Fb(:\\d+)?(/.*)?(\\?.*)?(#.*)?\$~i",$cg);}function
is_shortable($l){return
preg_match('~char|text|json|lob|geometry|point|linestring|polygon|string|bytea~',$l["type"]);}function
count_rows($Q,$Z,$ed,$s){global$y;$I=" FROM ".table($Q).($Z?" WHERE ".implode(" AND ",$Z):"");return($ed&&($y=="sql"||count($s)==1)?"SELECT COUNT(DISTINCT ".implode(", ",$s).")$I":"SELECT COUNT(*)".($ed?" FROM (SELECT 1$I GROUP BY ".implode(", ",$s).") x":$I));}function
slow_query($I){global$b,$T,$j;$i=$b->database();$zg=$b->queryTimeout();$Qf=$j->slowQuery($I,$zg);if(!$Qf&&support("kill")&&is_object($f=connect())&&($i==""||$f->select_db($i))){$jd=$f->result(connection_id());echo'<script',nonce(),'>
var timeout = setTimeout(function () {
	ajax(\'',js_escape(ME),'script=kill\', function () {
	}, \'kill=',$jd,'&token=',$T,'\');
}, ',1000*$zg,');
</script>
';}else$f=null;ob_flush();flush();$K=@get_key_vals(($Qf?$Qf:$I),$f,false);if($f){echo
script("clearTimeout(timeout);");ob_flush();flush();}return$K;}function
get_token(){$hf=rand(1,1e6);return($hf^$_SESSION["token"]).":$hf";}function
verify_token(){list($T,$hf)=explode(":",$_POST["token"]);return($hf^$_SESSION["token"])==$T;}function
lzw_decompress($Da){$Cb=256;$Ea=8;$Ta=array();$sf=0;$tf=0;for($t=0;$t<strlen($Da);$t++){$sf=($sf<<8)+ord($Da[$t]);$tf+=8;if($tf>=$Ea){$tf-=$Ea;$Ta[]=$sf>>$tf;$sf&=(1<<$tf)-1;$Cb++;if($Cb>>$Ea)$Ea++;}}$Bb=range("\0","\xFF");$K="";foreach($Ta
as$t=>$Sa){$Qb=$Bb[$Sa];if(!isset($Qb))$Qb=$uh.$uh[0];$K.=$Qb;if($t)$Bb[]=$uh.$Qb[0];$uh=$Qb;}return$K;}function
on_help($Za,$Of=0){return
script("mixin(qsl('select, input'), {onmouseover: function (event) { helpMouseover.call(this, event, $Za, $Of) }, onmouseout: helpMouseout});","");}function
edit_form($a,$m,$L,$Zg){global$b,$y,$T,$k;$lg=$b->tableName(table_status1($a,true));page_header(($Zg?'Edit':'Insert'),$k,array("select"=>array($a,$lg)),$lg);if($L===false)echo"<p class='error'>".'No rows.'."\n";echo'<form action="" method="post" enctype="multipart/form-data" id="form">
';if(!$m)echo"<p class='error'>".'You have no privileges to update this table.'."\n";else{echo"<table cellspacing='0' class='layout'>".script("qsl('table').onkeydown = editingKeydown;");foreach($m
as$E=>$l){echo"<tr><th>".$b->fieldName($l);$xb=$_GET["set"][bracket_escape($E)];if($xb===null){$xb=$l["default"];if($l["type"]=="bit"&&preg_match("~^b'([01]*)'\$~",$xb,$pf))$xb=$pf[1];}$Y=($L!==null?($L[$E]!=""&&$y=="sql"&&preg_match("~enum|set~",$l["type"])?(is_array($L[$E])?array_sum($L[$E]):+$L[$E]):$L[$E]):(!$Zg&&$l["auto_increment"]?"":(isset($_GET["select"])?false:$xb)));if(!$_POST["save"]&&is_string($Y))$Y=$b->editVal($Y,$l);$q=($_POST["save"]?(string)$_POST["function"][$E]:($Zg&&preg_match('~^CURRENT_TIMESTAMP~i',$l["on_update"])?"now":($Y===false?null:($Y!==null?'':'NULL'))));if(preg_match("~time~",$l["type"])&&preg_match('~^CURRENT_TIMESTAMP~i',$Y)){$Y="";$q="now";}input($l,$Y,$q);echo"\n";}if(!support("table"))echo"<tr>"."<th><input name='field_keys[]'>".script("qsl('input').oninput = fieldChange;")."<td class='function'>".html_select("field_funs[]",$b->editFunctions(array("null"=>isset($_GET["select"]))))."<td><input name='field_vals[]'>"."\n";echo"</table>\n";}echo"<p>\n";if($m){echo"<input type='submit' value='".'Save'."'>\n";if(!isset($_GET["select"])){echo"<input type='submit' name='insert' value='".($Zg?'Save and continue edit':'Save and insert next')."' title='Ctrl+Shift+Enter'>\n",($Zg?script("qsl('input').onclick = function () { return !ajaxForm(this.form, '".'Saving'."…', this); };"):"");}}echo($Zg?"<input type='submit' name='delete' value='".'Delete'."'>".confirm()."\n":($_POST||!$m?"":script("focus(qsa('td', qs('#form'))[1].firstChild);")));if(isset($_GET["select"]))hidden_fields(array("check"=>(array)$_POST["check"],"clone"=>$_POST["clone"],"all"=>$_POST["all"]));echo'<input type="hidden" name="referer" value="',h(isset($_POST["referer"])?$_POST["referer"]:$_SERVER["HTTP_REFERER"]),'">
<input type="hidden" name="save" value="1">
<input type="hidden" name="token" value="',$T,'">
</form>
';}if(isset($_GET["file"])){if($_SERVER["HTTP_IF_MODIFIED_SINCE"]){header("HTTP/1.1 304 Not Modified");exit;}header("Expires: ".gmdate("D, d M Y H:i:s",time()+365*24*60*60)." GMT");header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");header("Cache-Control: immutable");if($_GET["file"]=="favicon.ico"){header("Content-Type: image/x-icon");echo
lzw_decompress("\0\0\0` \0�\0\n @\0�C��\"\0`E�Q����?�tvM'�Jd�d\\�b0\0�\"��fӈ��s5����A�XPaJ�0���8�#R�T��z`�#.��c�X��Ȁ?�-\0�Im?�.�M��\0ȯ(̉��/(%�\0");}elseif($_GET["file"]=="default.css"){header("Content-Type: text/css; charset=utf-8");echo
lzw_decompress("\n1̇�ٌ�l7��B1�4vb0��fs���n2B�ѱ٘�n:�#(�b.\rDc)��a7E����l�ñ��i1̎s���-4��f�	��i7�����t4���y�Zf4��i�AT�V V
��f:Ϧ,:1�Qݼ�b2`�#�>:7G�1���s��L�XD*bv<܌#�e@�:4�!fo���t:<��咾�o��\ni���',�a_�:�i�Bv�|N�4.5Nf�i�vp�h��l��֚�O����= �OFQ��k\$��i����d2T�p��6�����-�Z�����6����h:�a�,����2�#8А�#��6 n����J��h�t�����4O42��ok��*r���@p@�!������?�6��r[��L���:2B�j�!Hb��P�=!1V�\"��0��\nS���D7��Dڛ�C!�!��Gʌ� �+�=tC�.C��:+��=�������%�c�1MR/�EȒ4���2�䱠�`�8(�ӹ[W
��=�yS�b�=�-ܹBS+
ɯ�����@pL4Yd��q�����6�3Ĭ��Ac܌�Ψ�k�[&>���Z�pkm]�u-c:���Nt�δpҝ��8�=�#��[.��ޯ�~���m�y�PP�|I֛��� Q�9v[�Q��\n��r�'g�+��T�2��V��z�4��8��(	�Ey*#j�2]��R����)��[N�R\$�<>:�>\$;�>��\r���H��T�\n w�N �wأ��<��Gw����\\Y�_�Rt^�>�\r}��S\rz�4=�\nL�%J��\",Z�8����i�0u�?�����s3#�ى�:���㽖��E]x���s^8��K^��*0��w����~���:��i���v2w��� �^7���7�c��u+U%�{P�*4̼�LX./!��1C��qx!H��Fd��L���Ġ�`6�� 5��f��Ć�= H�l �V1��\0a2�;��6����_ه�\0&�Z�S�d)KE'��n��[
X��\0ZɊ�F[P�ޘ@��!��Y�,`�\"ڷ��0Ee9
yF>��9b����F5:���\0}Ĵ��(\$����37H��� M�A��6R��{Mq�7G��C�C�m2�(�Ct>[�-t�/&C�]�etG�̬4@r>���<�Sq�/���Q�hm���������L��#��K�|���6fKP�\r%t��V=\"�SH\$�} ��)w�,W\0F��u@�b
�9�\rr�2�#�D��X���yOI�>��n
��Ǣ%���'��_��t\rτz�\\1�hl�]Q5Mp6k���qh�\$�H~�|��!*4����`S���S t�PP\\g��7�\n- �:袪p����l�B���7Өc�(wO0\\: ��w���p4���{T��jO�6HÊ�r���q \n��%%�y']\$��a�Z�.fc�q*-�FW��k��z���j���lg�:�\$\"�N�\r#�d�Â���sc�̠��\"j�\r�����Ւ�Ph�1/��DA)���[�kn�p76�Y��R{�M�P���@\n-�a�6��[�zJH,�dl�B�h�o�����+�#Dr^�^��e��E��� ĜaP���JG�z��t�2�X�����V�����ȳ��B_%K=E��b弾�§kU(.! ܮ8����I.@�K�xn���:�P�3 2��m�H		C*�:v�T�\nR�����
0u�����ҧ]�����P
/�JQd�{L�޳:Y��2b��T ��3�4���c�V=���L4��r�!�B�Y�6��MeL  ������i�o�9< G��ƕЙMhm^�U�N���
�Tr
5HiM�/�n�흳T��[-<__�3/Xr(<���������uҖGNX20�\r\$^��:'9�O��;�k����f��N'a����b�,�V��1��HI!%6@��\$�EGڜ�1�(mU��rս���`��iN+Ü�)���0l��f0��[U��V��-:I^��\$�s�b\re��ug�h�~9�߈�b�����f�+0�� hXrݬ�!\$�e,�w+����3��_�A�k��\nk�r�ʛcuWdY�\\�={.�č���g��p8�t\rRZ�v�J:�>��Y|+�@����C�t\r��jt��6��
%�?��ǎ�>�/
�����9F`ו��v~K�����R�W��z��lm�wL�9Y�*q�x�z��Se�ݛ����~�D�����x���ɟi7�2���Oݻ ��_{��53��t���_��z�3�d)�C��\$?KӪP�%��T&��&\0P�NA�^�~���p � �Ϝ���\r\$�����b*+D6궦ψ��J\$(�ol��h&��KBS>���;z��x�oz>��o�Z�\nʋ[�v���Ȝ��2�OxِV�0f�����2Bl�bk�6Zk�hXcd�0*�KT�H=�� π�p0�lV��
��\r���n�m��)(�(�:#����E��:C�C��
�\r�G\ré0��i����:`Z1Q\n:��\r\0�
��q���:`�-�M#}1;����q�#|�S���hl�D�\0fiDp�L��``����0y��1���\r�=�MQ\\��%oq��\0�
�1�21�1�� ���ќbi:��\r�/Ѣ� ` )��0��@���I1�N�C�����O��Z��1���q1 ����,�\rdI�Ǧv�j�1 t�B���⁒0:�0��1�A2V���0���%�fi3!&Q�Rc%�q&w%��\r��V�#���Qw`�% ���m*r��y&i�+r{*��(rg(�#(2�(��)R@i�-�� ���1\"\0��R���.e.r��,�ry(2�C��b�!Bޏ3%ҵ,R�1��&��t��b�a\rL��-3�����\0�
�Bp�1�94�O'R�3*��=\$�[�^iI;/3i�5�
&�}17�# ѹ8��\"�7��8�9*�23�!�!1\\\0�8��rk9�;S�23�
�ړ*�:q]5S<��#3�83�#e�=�>~9S螳�r�)��T*a�@і�bes���:-���*;,�ؙ3!i���LҲ�#1 �+n� �*��@�3i7�1���_�F�S;3�F�\rA��3�>�x:� \r�0��@�-�/��w��7��S�J3� �.F�\$O�B���%4�+t�'g�Lq\rJt�J��M2\r��7��T@���)ⓣd��2�P>ΰ��Fi಴�\nr\0��b�k(�D���KQ����1�\"2t����P�\r��,\$KCt�5��#��)��P#Pi.�U2�C�~�\"�");}elseif($_GET["file"]=="functions.js"){header("Content-Type: text/javascript; charset=utf-8");echo
lzw_decompress("f:��gCI��\n8�� 3)��7���81��x:\nOg#)��r7\n\"��`�|2�gSi�H)N�S��\r��\"0��@�)�`(\$s6O!��V/=��' T4�=��iS��6IO�G#�X�VC��s��Z1.�hp8,�[�H�
~Cz���2�l�c3���s���I�b�4\n�F8T��I���U*fz��r0�E����y���f�Y.:��I��(�c��΋!�_l��^�^(��N{S��)r�q�Y��l٦3�3�\n�+G���y���i���xV3w�uh�^r����a۔���c��\r���(.��Ch�<\r)�ѣ�`�7���43'm5���\n�P�:2�P����q ���C�}ī�����38�B�0�hR��r(�0��b\\0�Hr44��B�!�p�\$�rZZ�2܉.Ƀ(\\�5�
|\nC(�\"��P���.
��N�RT�Γ��>�HN��8HP�\\�7Jp~���2%��OC�1�.��C8·H��*�j����S(�/��6KU����<2�pOI���`���ⳈdO�H��5�-��4��pX25-Ң�ۈ�z7��\"(�P�\\32:]U����߅!]�<�A�ۤ���iڰ�l\r�\0v��#J8��wm��ɤ�<�ɠ��%m;p#�`X�D���iZ��N0����9
��占��`��wJ�D��2�9t��*��y��NiIh\\9����:����xﭵyl*�Ȉ��Y�����8�W��?���ޛ3���!\"6�n[��\r�*\$�Ƨ�nzx�9\r�|*3ףp�ﻶ�:(p\\;��mz���9����8N���j2����\r�H�H&��(�z��7i�k� ����c��e���t���2:SH�Ƞ�/)�x�@��t�ri9����8����yҷ���V�+^Wڦ��kZ�Y�l�ʣ���4��Ƌ������\\E�{�7\0�p���D��i�-T����0l�%=���˃9(�5�\n\n�n,4�\0�a} ܃.��Rs\02B\\�b1�S�\0003,�XPHJsp�d�K� CA!�2*W����2\$�+�f^\n�1����zE� Iv�\\�2��.*A���E(d ���b��܄��9����Dh�&��?�H�s�Q�2�x~nÁJ�T2�&��e R���G�Q��Tw�ݑ��P���\\�)6�����sh\\3�\0R	�'\r+*;R�H�.�!�[�'~�%t< �p�K#�!�l���Le����,���&�\$	��`��CX��ӆ0֭�� ��:M�h	�ڜG��!&3�D�<!�23��?h�J�e  ��h�\r�m���Ni�������N�Hl7��v��WI�.
��-�5֧ey �\rEJ\ni*
�\$ @�RU0,\$U�E����ªu)@(t�SJk�p!�~���d`�>��\n
�;#\rp9�jɹ�]&Nc(r���TQU��S��\08n`��y�b���L�O5��,��>���x���f䴒���+��\"�I�{kM�[\r%�[	�e
�a�1! ����Ԯ�F@�b)R��72��0�\nW���L�ܜҮtd�+��� 0wgl�0n@��ɢ�i�M��\nA�M5n�\$E�ױN��l�����%�1 A������k�r�iFB���ol,muNx-�_�֤C( ��f�l\r1p[9x(i�BҖ��zQl��8C�	��XU Tb��I�`�p+V\0��;�Cb��X�+ϒ�s��]H��[�k�x�G*�]�awn�!�6�����mS���I��K�~/�ӥ7��eeN��S�/;d�A�>}l~��� �%^�f�آpڜDE��a��t\nx=�kЎ�*d���T����j2��j��\n��� ,�e=��M84���a�j@�T�s���nf��\n�6�\rd��0���Y�'%ԓ��~	�Ҩ�<��
�AH�G��8���΃\$z��{���u2*��a��>�(w�K.bP�{��o��´�z�#�2�8=�
8>���A,�e���+�C�x�*���-b=m���,�a��lzk���\$W�,�m�Ji�ʧ���+���0�[
��.R�sK���X��Z
L��2�`�(�C�vZ������\$�׹,�D?H��NxX��)��M��\$�,��*\nѣ\$<q�şh!��S����xsA!�:�K��}�������R��A2k�X�p\n<� ����l���3�����VV�}�g&Yݍ!�+�;<�Y��YE3r�َ��C�o5����ճ�kk�����ۣ��t��U���)�[����}��u��l�:D��+Ϗ _o��h140���0��b�K�㬒�����lG��#��������|Ud�IK���7�^��@��O\0H��Hi�6\r����\\cg\0���2�B�*e��\n��	�zr�!�nWz&� {H��'\$X �w@�8�DGr*���H�'p#�Į���\nd���
,���
,�;g~�\0�#����E��\r�I`��'��%E�.�]`�Л��%&��m��\r��%4S�v�#\n��fH\$%�-�#���qB�����Q-�c2���&���]�� �qh\r�l]�s�� �h�
7�n#����-�jE�Fr�l&d����z�F6����\"���|���s@����z)0rpڏ\0�X\0���|DL<!��o�*�D�{.B<E���0nB(� �|\r\n�^���� h�!���r\$��(^�~����/p�q��B��O� ���,\\��#RR��%���d�Hj�
`���
�̭ V� bS�d�i�E���oh�r<i/k\$-�\$o��+�ŋ��l��O�&evƒ�i�jMPA'u'���( M(h/+��WD�So�.
n�.�n���(�(\"���h�&p��/�/1D̊�j娸E��&⦀�,'l\$/.,�d���W�bbO3�B�sH�:J`!�.���������,F��7(��Կ�

�1�l�s �Ҏ���Ţq�X\r����~R鰱`�Ҟ�Y*�:R��rJ��%L�+n�\"��\r��͇H!qb�2�Li�%����Wj#9��ObE.I:�6�7\0�6+�%�.����a7E8VS�? (DG�ӳB�%;���/<�����\r � �>�QV�t/8�c8�\$\0����RV� I8�RW���\n��v��yC��-�5F��iQ0��_�IE�sIR!���X
k��z@��`���D�`DV!C�8��\r���b�3�!3�@�33N}�ZB�3F.H}�30��M(�>��}�\\�t�f�f���I\r���337 X�\"td�,\nbtNO`P�;�ܕҭ���\$\n����Zѭ5U5WU�^ho���t�PM/5K4Ej �KQ&53GX�Xx)�<5D�^���V�\n�r�5b܀\\J\">��1S\r[-��D
u�\r���)00�Y��ˢ�k{\n��#��\r�^��|�uܻU�_n�U4�U�~Yt�\rI��@䏳�R �3:�uePMS�0T�wW�X���D��KF5����;U�\n�OY��Y�Q,M[\0�_�D���W��J*�\rg(]�\r\"ZC��6u�+�Y��Y6ô�0�q�(��8}��3AX3T �h9j�j�f cMt�PJbqMP5>������Y�k%&\\�1d��E4� �Yn���\$<�U]Ӊ1�mbֶ�^�����\"NV��p��p��eM���W�ܢ�\\�)\n �\nf7\n� 2
�cr8��=K
7tV����7P�� L��a6��v@'�6i��j&>��;��`��a	\0pڨ(�J��)�\\��n��Ĭm\0��2��eqJ��P��h��f
j��\"[\0��� �X,<\\������+md��~ �����s%o��mn�),ׄ�ԇ�\r4��8\r����mE�H]�����HW�M0D�߀��~�ˁ�K�
�E}����|f�^���\r>�-z]2s�xD�d[s�t�S��\0Qf- K`���t���wT�9��Z��	�\nB�9 Nb��<�B�I5o �oJ�p��Jd��\r�hލ��2�\"�yG��C��s�ӕ�V���%zr+z���\\�����m ��T ���@Y2lQ<2O+�%��.Ӄh�,A���Z��2R��1��/�hH\r�X��aNB&� �M@�[x��ʮ���8&L�V͜v�*�j�ۚ H ��\\٪	���&s�\0Q�`\\\"�b��	��\rBs��w�B	��ݞN`�7�Co(ٿ �\nè��h1���*E���S��U�0U�t�#|�4�'{���� #�5	 �	p��yB�@R���p�@|��7\r�\0 �_B�^ z<B�@W4&K�s��xO׷�P�@X�]�����w>�Ze{��LY��Lڐ�\\�(*R`�	�\n������QC�(*���c�;�l�p�X|`N���\$�[���@�U������Z�`Zd\"\\\"����)� I�:�t��oD�
\0[�(���-���'��	���`hu%��,����I�7ī���m�V�}��N�ͳ\$�E��Yf&1����]]pz�U�x\r�}��;w�UX �\\��a^ �U�0SZOD�RK��&�Z\\Oq}ƾw���g��I��V���	5�k���?�={������*�k�@[u�h�v�m��a;]���&��\"��/\$\0C�قdSg�k��{�\0�\n`�	���C ���a�r\r��2 G׌��O{��[����C��FKZ�j��FY�B�pFk��0<���D<JE�Zb^�.�2��8�U@*�5fk��FD���4��DU76�4Q�@��K+���J�����@�=��WIF\$�85 M��N�\$R�\0�5 �\r��_���E���I�ϳN�l���y\\��qU��Q���\n@�����cp���P۱+7ԽN\r�R{*�qm�F	M}I8�`W\0�8��T\r�*NpT�b�d<�ˤ�8�F��_�+ܻT�eN#]�d;�,��
�~�U|0VRe�����֎Y|,d Y�<Ͳ]���ᷗɔ=��mś�,
\r�j\r5�p�du �
�
�fp�+�J����X^��\n ��)�>-�h�����<�6��b �dmh��@q���Ah�),J��W��cm�em]��\\�)1Zb0�����Y�]ym��f�e��;���O��W�apDW�����zE���\"�\$��=k���!8�怂g@�-Q��/e&�Ƈ�v_�xn\r�e3{U�4���n{�:B����sm��Y d���7}3?*�t����lT�}�~�����=c�����ǹ�{�8S�A
\$�}�Q\"���;TW�98��{IDq������ǘ�O�[�&�]�؁��s����-��\r6��qq� h�e5�\0Ң���*�b�IS���
�ή9y�p�-��`{��ɖkP�0T<��Z9�0<ՙͩ�;[��g��\nK�
\n� \0��*�\nb7(�_�@,�E2\r�]�K�*\0��p C\\Ѣ,0�^�MЧ����@�;X\r��?\$\r�j�*�O��B��P��1�hLK����3�/��a@|
���w �(p��0����uo	T/b���B��dk�L8�Db�D��`����*3؅N����M	w�k�z����̫q�!�n�����~����ʴ��Eͦ�}Q�
m\0��4@;��&�@�\"B���	P� m5p����)Ƅ�@2�M��;�\r��b��05	��\0[�N9�hY�່�t1e�A�o`�X���g�Ub5�X�6����hUp��0&*��E�:�qt%>���
Ya�����hb�b ���L��8U�rC��[V�I�9Dд{����]�!�a��=T��&B5��\0~y��U�+��\"��h�H�Tb\".\r�̠<)�o��F�m��jb!ڇDE�%� I�ڢ�DAm2ki�!���\"��N�w�T�ǀ�u��*h�1UdV��D#)����`�x\\CM=r)�� ��80���cSD��ޕW���)\\-�b!�7����G_��Z��2yȅq�)�}(\$��Ët\0�'�ȴpZ,a�˘�8�E��ї���4�#���~Rϐ��t��=�ap~ŀ<wU��Q+��l��R��{ќV�	ոo%��a.Y�c}\n�3'Z |`��6�4HUep�H1���d��\\\\����do\\�i��a���5���u��8�A�;����P�\"ǖ.玼~4�����>��۞��%����VG'z��A!%\\=AGM�p}C��?/X���J���TR(ƹ����`��#Z6�t�iua��
u��t���p�� �����O1��#pTa#�<.�+�� �\\I{��`M\nk% �IP|GʒPA��;W��Š�5B9%.@I#�P�:E��\$�+E���,:�|U� ��k���e0��2L�9)�`T+\$�l��U\"+��\0�\$\n�_�ђ�(��4DR���'�1\"h6�%<*/�\\�\"��=y��F}l���#70��E�m����A(�T�G]@�Ѯ.IK�W���ѥxD�.�V.�D\\��*{��AAeԌf��3��U؜@Uw.�5�ZĆS�*<BA�#�\0O.����]����Npi��U)�s(�쒰�a��ag�%���Ă�yx#��[�
�eX�4� ,�Ho�8N�I��	� %y-�p��T����dw��[�^gxfb�(U��~��\0P��+Ã'h�Ak�π��ٟ��.\"2@�f�����O�>tѣ\"����i\0j3�X��w!/��^��bq��� (5*�\0Z��9�\\�\rJ@ZAQE͑{��x�L/��| # 	�D���*kr���QE� `.\0_�qd�B(�.4�%S�l��*�Ne(\n��'4��`@mx��:�����S���4���N4�s��'=6 �����8��Y;�̆s�Pn'��9͌s,�&y!�>\0[�S(N��11\n�VfΠ���B���ƕ�%�~E�3���H4��(B�\"����� s3m�'p�<��� ����LԱp���E�B��5 ����2Yѧ&�������\"(�r�G�Xxɩ��R�O0�Jn�a�1`�呜g�n�@(	��y%��K�c<ɕ��6������dH�;�c.�ޡ�Kx��^=�+�\0�3�&��D�\rʉC��;)�\\b���E���*Q��D� ����ݖ�t��{\\��p3�T��E\0)	%b��*쭤2�h{�X�����P�K�H(��Q\n�e�!��F�ɓe
�aC�B�.�%�	ܡ�C�
Jp���\$���M�Z2|� )�N�Z\\Z_��)�T �y\"
���q+�Yzxb�EU�e\"�
LZc��c/=aa��L�0��
k�(��G5���t�[�])ƍ� �8���62/�<�aM��.��֌y�,���Y�k\nPC.��vJ6�2� �N�fS���]82��5�;��\0��	\"*&/�eS��T�(�-N�aCL1t#\"�#�4Ƣ�1�^�6D��`��ȑ�+����YFh�0�FI�\$��\\�P��u0nmY�4b�#��\"�p�#�&R8�줁�2(U\0��%�Si�qe3�kB����j�gI�U��U���3u� NBb�a41�v� @dh�aa�LKx�ռ���)�	�P(��-u��JGX�\nK�/������\\�i���\0^�\$�,�|�Z��(Rv*��EbE{Z��H�e�\n���P�ɠ���uNXb`XTU06��a�XP=Q*ΐ�dt*z+H@����Iv�Z���g�q�I^R�\0��A\n *�!�8|\$pr���!WF�����OB�+�Vi��u�'�KYz(��)�ed�3\\��Ր�	�\nz&�^bߋ J^V%t+�Ti[Q4&����t�\\��6�i�\r�s*����H��&[W'�ZŖ'���+Bx[	,¹� زŦ��q��8�~3�ځ��@'	�i�f���.J�ʈT���X1-����&3��6������f@|O`b�UeD\0�:���p�SjMD�Qt\n����g����a�y\$s��`\"��5����56V���| `&�����又7��:�r5:���/'m�Piw	A\rP��G�X#H���Y\n����&R�t{�f���m@8�x��c�m��FD3�\"����]�u�)la�Z�:#�Y�KKhW�^Lݵ��m�����p�6}���
i[���W���m�ۋtZ�M���e�(oe�rp�[PY������_����oR�1�\"R)���\$H�;�\0�����%Y#��-Ihx�*ɔQR�^Z��.Y�W��*��LZ�
] 
jU��V��\\;4z#�v��:R��)�*:��ǟ���iXbs.hqZT��\"��I �h��\0�;���@Zx���I���N'�Ӎ~���\r���BB���Òh���YG��F4)��i%P����xx\n+�
�2�5ݬ�h���'�݂,��^^9̠-��l�۷n��mQ�i� \0��B�8�n�:T1��1RĢ�Y����9�=�p�s-�^�f%�q't 8�(����@�o��Z1 �h��P�?���+g_U�q	��^~�@n��ξ ��P&�g��C9|�9_���c�U����5_��
�?�E�!�'�T]�����Y��\rE�pNJROӀ���\nS�ܜ��l�e�B8�� \n}6���| �� �9 N��� �Q׽�ǸI5yQ�D��ʉ���uj*?m\\M�޲`��d��U(\$��N~UY#}�n�@h:�H��\rZ'�@j���4�2I�����֡�� 0h@\\Ե�\0�8P3�B.�0�a���JLh\r?K\\�NxQ0��#ՅH��t���c��?�,���t0�;up��0d7� ��ʰ<a�
i�2�s�9�b��Ox���\0P�2��@,�U�\0�[V���h|BQ X�5Ҙ_���1Ar8����r �}��N���Db�&���\"a|?�0?���Oq[�8�^K���Q�6�[�v��ѕ۾���ư�n�	�4S -R8��e��y�1���Go�\r�d������IP�6�mͳ���͆������)G�AK*�x��U��
�Rma�%ƣHsE����9L}�s��`6@Q��g#a����F@B'<r��˓[��E\$i#�\"Ś,�7i����� �t��R 9���k�P�s���)÷ʺ���t����*`gʮ6�L�w���L��^i��PY%�%v�a�ԙ � 2�^����ch��,�!w^��M3WE�����=�
���Zb\$���~V�Xk����\0[`���I����bc0Mk��C���F9��h�J �ӗ�����(K�X�Ў�ŷ�auQ��qw��=��Y���8�s����|\r�ވ1�ļ\"N�uL�s2��ͤ0x����T`��B�v��2��9D����1�U�`ɕ/�1:,&�Ǚ��	8���\$��ojU��9�\n�џ��`6��#7A͐X-w�|��F�!ضI��u����f�����7���\0?9 O�� �ͥ�*�J5�������!طk����rN�z|~�3�v��~ץ�c�n�h<&m`P4M%�'G���f�f0�ӗH��>��,-���Z;��\0�Ŧ.#]����志h���]�BhPÉ�*��̵F\r
��
�AHf�A���B���<�e��G3Vƛ\"����~7�y�p��OS�f�A9��{u\n�M��Z��I5X�P4Lzm�#m�`h\"��\n����4ǜ�J��\n9 J=1�z�M��-A�-`\"�XR�rG�dMXc��(՘Bٜ+[��)�\n��|�p��w����Ckt�\n�|~\0z姯>���X)	�v������5�ְ�[�.���)I?���r[��|�X3!>\r�P�5�	���\ro���ɽ�u�X))܋n^\n���W��n��c��Wc���M�ӵ yo��.�
��q5JsKVWV�H#�λv��+�P�&�r�~G�\r�px(��9<���<&A2 Y�9���s-���&��G��T� \"���yd�Ye��p�5|�=��\$��Ne���W0;���MOHɍ&39�\$�@�an.|+bfx��1C�i����H������ڏ���R��Km8P.���%�Z\0^  �9��|�CXlH��Ğ��z\\�24n+��ظ����ܹ��F]�����F��ո�\0�w�5)��f��cy{�0�P4���5��zaƼ��)_�QY3�&��nݛ�,���K��_�Y�W0Y��.s�-i=��e�,u@|Uvt!#��δ����^���&���dSր�0�8ݤ�g.�oG@\\(�c�t\r�XG�֕̃��TڍF�em��:�D��֍9)`EYk�Mk��\$ȊONӂJ��e�7�8y�M�n�Z*|�r�	D�ZB[ҡ@T!�\0�00�L���|,���w߾f\\&��e�mj��&/	ً����B�ե|rI��bx�QD��wJ��|����� M�`ߋ-5t�4�X�w�W��O�Ž��u��_>	x�+^2�5#��-�����'����f�ȩ奥-b�KjQ;�&>�3�ⲻ'jtYq�ާ�+Jv\"j�t~_◎�E�BORԾ�0�)�p�29IB ����e�\"I;۩X�\$,p0��
_K���\$ċ�v��,?
1��Ջ<LD;rJ;��lg.��~;�U W���v��ό0P+g0��r+IAA*�\0|��S�o �\\�S�5�u��'(����|������W��5;\$5\0��{�� ;d�i�t�đ� ��:�)�Ⱥ)�.�;��j%\r���F�=��D��]H���\0�	 N @�!��+|�d!.�H|�M���COU�wI�R�|��H�R�T�@�%<��n���n7r���]�
c#;��\"f�A�9�ʾd��',��'U��K�r^���_:Ry�O~m!ۥ�j>�S��\"[�q��ܽ뜋�\\�8Ms\0��7��_�U̎V�f6�K�D���s4S��P_=\"A��,&G�=���X�9I�`o#IF��SA���A�;4kY�N@��<�@gu|It\r��.�R 9�:���y�K� �����y�*E�`r�Y����	�\${�6�\0����hL�3�����\" _\$U��_�(�G�C0�(Օ��1F��Mz����{�Q!\r��N�xCsa�5Ш�Oz	M���G�`Q�4�����II�Ja�6盀�T`(�M��J\\Wǂ���Eju�8��B���Q[�?��_%+�O�+|�����w(e������\\U���ރU�Z�4�\n�P @�P<Ț4�C� ���.K!���M#oSY3�L���B�\$��0{�H�t��)Jp�\$\rJ˝y\"��;���@,�_�Z��\$�������`�T���c�S�%�C�(+oO��@�\0^kX��@|��͇�U@���(h�B�>��Vn�\$�H���2�(�A�L�ma�hÆ�I����Ki�:�'��E��V�C�EE5�aF���b��H�dA|���\"�ǊB�,��X�Jv
N��yJ����@���ld��W���+&w�]\0� �od� ��K�y�.Ȉ
H̉��UCpLa��/�\rK����t�����8 c�i��o��S�τ���`=��E\0;�|'�llcTHU�?Ps�=����b������8	\r־fߝ������~�
K���[�>�8MlF𝚏�����х񿴀���<�����^��k�@׸���/u�� .�g�+��`�%�l�2\n�[v��iS���]}I�A�z�*���~%�_c|���-Q7�:ҳ��ɪ_;�b��g}�1?p>W܀�����`=�ؔ5i���~��?{��~���[|�E�_����UN�]?7pt?22?��Tr������T���]?f������,w�����Ѻ�2�y�:P.T�1G����*��hb����?��Q ���� �?�W�r�\0�b�`*��:=v hv\0��������%L:V(�P�8wD�1賐a\0�o���p4�D&���@�a�5��m�P��Z�ڒE���]wI^)Q� �w�(#-��u#��Z��*0�L���d��G�5T�@p/����b�:�\"|01\0��`
���ڐb�:P�����'!��Ą\r�\0fx���4\0�ߑ����H[,p<��MU��T�/a\rLC�bE��\\�A�BV��޻MF/����v�\n<�MB&DO���f���,:M\rU4��MxF}`҉�#0�}�����B�o0��&� N፩p�:�~�Ǎ\r�M�|�N�R�\n\"	#'@�b��� Pq�ǽJ\\�<�:h!pG���dd\n�@jm整��p�1�� PX�� `#/|���ﺾ��\"�n c�D]���8�r6 �{5�~�\r\0A��De� q\\o�B! �[ ���0BD����3�T��/0B�r����I��P��;��e��P�M��á���#��p�Z?��`pW����\0`�\0");}elseif($_GET["file"]=="jush.js"){header("Content-Type: text/javascript; charset=utf-8");echo
lzw_decompress("v0��F����==��FS	��_6MƳ���r:�E�CI��o:� C��Xc��\r�؄J(:=�E���a28�x�?�'�i�SANN���xs�N B��Vl0���S	��Ul�(D|҄��P��>�E�㩶yH
ch��-3Eb�� �b��pE�p�9.����~\n�?Kb�iw|�`��d.�x8EN��!��2��3���\r���Y���y6GFmY�8o7\n\r�0��\0�Dbc�!�Q7Шd8���~��N)�Eг`�Ns��`�S)�O�
��/�<�x�9�o�����3 n��2�!r�:;�+�9�CȨ���\n<�`��b�\\�?�`�4\r#`�<�Be�B#�N ��\r.D`��j�4���p�ar��
㢺�>�8�\$�c��1�c���c����{n7�� ��A�N�RLi\r1���!�(�
j´�+��62�X�8+����.\r����!x���h�'��6S�\0R����O�\n��1(W0���7 q��:N�E:68n+��մ5_(�s�\r��/m�6P�@�EQ���9\n�V-���\"�.:�J��8we�q�|؇�X�]��Y X�e�zW�� �7��Z1��hQf��u�j�4Z{p\\AU�J<��k��@�ɍ��@�}&���L7U�wuYh��2��@�u� P�7�A�h����3Û��XEͅZ�]�l�@Mp lv�)� � �HW���y>�Y�-�Y��/�������hC�[*��F�#~�!�`�\r#0P�C˝�f���
���\\���^�%B<�\\�f�ޱ�����&/�O��L\\jF��jZ�1�\\:ƴ>�N��XaF�A�������f�h{\"s\n�64������?�8�^p�\"띰�ȸ\\�e(�P�N��q[g��r�&�}Ph���W��*��r_s�P�h���\n���om������#���.�\0@�pdW �\$Һ�Q۽Tl0� ��HdH�)��ۏ��)P���H�g�� U����B�e\r�t:��\0)\"�t�,�����[�(D�O\nR8!�Ƭ֚��lA�V��4�h��Sq<��@}���gK�]���]�=90��'����wA<����a�~��W��D|A���2�X�U2��y Ŋ��=�p)�\0P	�s��n�3�r�f\0�F���v��G��I@�%���+��_I`����\r.��N���KI�[�ʖSJ���aUf�Sz���M��
%��\"Q|9��Bc�a�q\0�8�#�<a��:z1Uf��>�Z�l������e5#U@iUG��n�%Ұs���;gxL �pP�?B��Q�\\�b��龒Q�=7�:��ݡQ�\r:�t�:y(� �\n�d)� ��\n�X;����CaA�\r���P�GH�!���@�9\n\nAl~H���V\ns��ի�Ư�bBr���������3�\r�P�%
�ф\r}b/�Α\$�5�P�C�\"w�B_��U�gAt��夅�^Q��U���j����Bvh졄4�)��+�)<�j^�<L��4U*���Bg�����*n�ʖ�-����	9
O\$��طzyM�3�\\9���.o�����E(i� ��
���7	tߚ�-&�\nj!\r��y�y�D1g���]��yR�7\"������~���� )TZ0E9M�YZt
Xe!�f�@�{Ȭyl	8�;���R{��8� Į�e�+UL�'�F�1���8PE5-	�_!�7��[2�J��;�HR��ǹ�8p痲݇@��0,ծpsK0\r�4��\$sJ���4�DZ��I��'\$cL�R��MpY&����i�z3G�zҚJ%��P�-��[�/x�T�{p��z�C�v���:�V'�\\��KJa��M�&���Ӿ\"�e�o^Q+h^��iT��1�OR�l�,5[ݘ\$��)��jLƁU`�S�`Z^�|��r�=��n登��TU	1Hyk��t+\0v�D�\r	<��ƙ��j G���t�*3%k�Y
ܲT*�|\"C��l  hE�(�\r�8r��{��0����D�_��.6и�;����rBj�O'ۜ���>\$��`^6��9�#����4X��mh8:��c��0��;�/ԉ����;�\\'(��t�'+
�����̷�^
�]��N�v��#�,�v���O�i�ϖ�>��<S�A\\�\\��!�3*tl`�u�\0p'�7�P�9�bs�{�v�{��7�\"{��r�a�(�^��E����g��/���U�9g���/��`�\nL\n�) ���(A�a�\" ���	�&�P��@O\n師0�(M&�FJ'�! �0�<�H�������*�|��*�OZ�m*n/b�/�������.��o\0��dn�)����i�:R���P2�m�\0/v�OX���Fʳψ���\"�����0�0�����0b��gj��\$�n�0}�	�@�
=MƂ
0n�P�/p�ot������.�̽
�g\0�) o�\n0���\rF��
� �b�i��o}\n�̯�	NQ
�'
�x�Fa�J���L������\r��\r����0� �'��d
	oep��4D��ʐ�q(~�� �\r�E��pr�QVFH�l��Kj���N&�j!�H`�_bh\r1���
n!�Ɏ�z�����\\��\r� ��`V_k��\"\\ׂ'V��\0ʾ`AC������V�`\r%�����\r����k@N����B�횙� �!�\n�\0Z�6�\$d��,%�%la�H�\n�#�S\$!\$@��2���I\$r�{!��J�2H�ZM\\��hb,�
'||cj~g�r�`�ļ�\$���+�A1�E���� <�L��\$�Y%-FD��d�L焳��\n@�bVf�;2_(��L�п��<%@ڜ ,\"�d��N�er�\0�`��Z��4�'ld9-�#`��Ŗ����j6�ƣ�v ���N�͐f��@܆�&�B\$
�(�Z&���278I ��P\rk\\���2`�\rdLb@E��2`P( B'�
����0�&��{���:��dB�1�^؉*\r\0c<K�|�5sZ�`���O3�5=@�5�C>@�W*	=\0N<g�6s67Sm7u?	{<&L�.3~D��\rŚ�x��),r�in�/��O\0o{0k�]3>m��1\0�I@�9T34+ԙ@e�GFMC�\rE3�Etm!�#1�D @�H(��n ��<g,V`R]@����3Cr7s~�GI�i@\0v��5\rV�'������P��\r�\$<b�%(�Dd��PW����b�fO �x\0�} �
�lb�&�vj4�LS��ִԶ5&d sF M�4��\".H�M0�1uL�\"��/J`�{�����xǐYu*\"U.I53Q�3Q��J��g��5�s���&jь��u�٭ЪGQ
MTmGB�t
l-c�*��\r��Z7���*hs/RUV����B�Nˈ�����Ԋ�i�Lk�.���t�龩�rYi���-S��3�\\�T�OM^�G>�ZQj� ��\"���i��MsS�S\$Ib	f���u����:�SB|i��Y¦��8	v �#�D�4`��.��^�H�M�_ռ�u��U�z`Z�J	e��@Ce��a�\"m�b�6ԯJR���T�?ԣXMZ��І��p����Qv�j�jV�{���C�\r��7�Tʞ� ��5{P��]�\r�?Q�AA�� ����2񾠓V)Ji��-N99f�l Jm��;u�@�<F�Ѡ�e�j��Ħ�I�<+CW@�����Z�l�1�<2�iF�7`KG�~L&+N��YtWH飑w	����l��s'g��q+L�zbiz���Ţ�.Њ�zW�� �zd�W����(�y)v�E4,\0�\"d��\$B�{��!)1U�5bp#�}m=��@�w�	P\0�\r�����`O|���	�ɍ����Y��JՂ�E��Ou�_�\n`F`� }M�.#1��f�*�ա��  �z�uc���� xf�8kZR�s2ʂ-���Z2�+�ʷ�(�sU �cD�ѷ�
��X!��u�&-vP�ر\0'L�X �L����o	
�
�>�Վ�\r@�P�\rxF��E��ȭ�%�
���=5N֜��?�7�N�Å�w�`�hX�98 �����q��z��d%6̂t�/������L��l��,�Ka�N~�����,�'�ǀM\rf9�w��!x��x[�ϑ�G�8;�xA��-I�&5\$�D\$���%��xѬ���´���]����&o�-3�9�L��z���y6�;u�zZ ��8�_�ɐx\0D?�X7����y�OY.#3�8��ǀ�e�Q�=؀*��G�wm ���Y��
���]YOY�F���)�z#\$e��)�/�z?�z;����^��F�Zg�����������`^�e����#� ������?��e��M��3u�偃0�>�\"?��@חXv�\"������*Ԣ\r6v~��OV~�&ר�^g���đٞ�'��f6:-Z~��O6;zx��;&!�+{9M�ٳd� \r,9����W��ݭ:�\r�ٜ��@睂+��]��-�[g��ۇ[s�[i��i�q��y��x�+�|7�{7�|w�}����E��W��Wk�|J؁��xm��q xwyj���#��e��(�������ߞþ��� {��ڏ�y���M���@��ɂ��Y�(g͚-����������J(���@�
;�y�#S���Y��p@�%�s��o�9;�������+��	�;����ZNٯº��� k�V��u�[�x��|q��ON?���	�`u� �6�|�|X
����س|O�x!�:� ��ϗY]�����c���\r�h�9n�������8'������\r S.1��USȸ��X��+��z]ɵ ��?����C�\r��\\
����\$�`��)U�|ˤ|Ѩx'՜����<�̙e�|�ͳ����L���M�y�(ۧ�l�к�O]{Ѿ�FD���}�yu��Ē�,XL\\�x��;U��Wt�v��\\OxWJ9Ȓ�R5�WiMi[�K� �f(\0�dĚ�迩�\r�M����7�;��������6�KʦI�\r���xv\r�V3���ɱ.��R������|��^2�^0߾\$�Q��[�D��ܣ�>1'^X
~t�1\"6L���+��A��e�����I��~����@����pM>�m<��SK��-H���T76�SMfg�=��GPʰ�P�\r��>�����2Sb\$�C[���(�)��%Q#G`u��Gwp\rk�Ke�zhj��zi(��rO�������T=�7���~�4\"ef�~
�d���V�Z���U�-�b'V�J�Z7���)T��8.<�RM�\$�����'�by�\n5����_��w����U�`ei޿J�b�g�u�S��?��`���+��� M�g�7`���\0�_�-���_��?�F�\0����X���[��J�8&~D#��{P���4ܗ��\"�\0��������@ғ��\0F ?*��^��w�О:���u��3xK�^�w���߯�y[Ԟ(���#�/zr_�g��?�\0?�1wMR &M���?�St�T]ݴG�:I����)��B��
 v����1�<�t��6�:�W{���x:=��ޚ��:�!!\0x�����q&��0}z\"]��o�z���j�w�����6��J�P۞[\\ }��`S�\0�qHM�/7B��P���]FT��8S5�
/I�\r�\n ��O�0aQ\n�>�2�j�;=ڬ�dA=�p�VL)X�\n¦`e\$�TƦQJ����lJ����y�I�	�:��
��B�bP���Z��n����U;>_�\n	�����`��uM򌂂�֍m����Lw�B\0\\b8�M��[z��&�1�\0�	�\r�T������+\\�3�Plb4-)%Wd#\n��r��MX\"ϡ�(Ei11(b`@f����S���j�D��bf�}�r����D�R1���b��A��Iy\"�Wv��gC�I�J8z\"P\\i�\\m~ZR��v�1ZB5I��i@x����-�uM\njK�U�h\$o��JϤ!�L\"#p7\0� P�\0�D�\$	�GK4e��\$�\nG�?�3�EAJ
F4�Ip\0��F�4��<f@� %q�<k�w��	�LOp\0�x��(	�G>�@�����9\0T����GB7�-�����G:<Q��#���Ǵ�1�&tz��0*J=�'�J>���8q��Х���	�O��X�F��Q�,����\"9��p�*�6
6A'�,y��IF�R��T���\"��H�R�!�j#kyF���e��z�����G\0�p��aJ`C�i�@�T�|\n�Ix�K\"��*��Tk\$c��ƔaAh��!�\"�E\0O�d�Sx�
\0T	�\0���!F�\n�U�|�#S&		IvL\"����\$h���EA�N\$�%%�/\nP�1���{��) <���L���-R1��6���<�@O*\0J@q��Ԫ#�@ǵ0\$t�|�]�`��ĊA]���Pᑀ�C�p\\pҤ\0���7���@9�b�m�r�o�C+�]�Jr�f��\r�)d�����^h�I\\�. g��>���8���'�H�f�rJ�[r�o���.�v���#�#yR�+�y��^����F\0᱁�]!ɕ�ޔ++�_�,�\0<@�M-�2W���R
,c���e2�*@\0�P ��c�a0�\\P���O��
�`I_2Qs\$�w��=:�z\0)�`�
h������ �\nJ@@ʫ�\0�� 6qT��4J%�N-�m����.ɋ%*cn��N�6\"\r͑�����f�A���
p�MۀI7\0�M�>lO�4�S	7�c��
�\"�ߧ\0�6�ps�����y.��	���RK��PAo1F�tI�b*��<���@�7�˂p,�0N��:��N�m�,�xO%�!��v����gz(�M���I��	��~y���h\0U:��OZyA8�<2����us�~l���E�O�0��0]'�>��ɍ�:���;�/��w�����'~3GΖ~ӭ����c.	���vT\0c�t'�;P�\$�\$
����-�s��e|�!�@d�Obw��c��'�@`P\"x�
���0O�5�/|�U{:b�R\"�0�шk���`BD�\nk�P��c��4�^ p6S`��\$�f;�7�?ls��߆gD�'4Xja	A��E%�	86b�:qr
\r�]C8�c�F\n'ьf_9�%(��*�~��iS��
��@(85�T��[��Jڍ4�I�l=��Q�\$d��h�@D	-��!�_]��H�Ɗ�k6:���\\M-����\r�FJ>\n.��q�eG�5QZ����' ɢ���ہ0��zP��#������r���t����ˎ��<Q��T��3�D\\����pOE �%)77�Wt�[��@� ���\$F)�5qG0�-�W�v�`�*)Rr��=9qE*K\$g	��A!�PjBT:�K���!��H� R0?�6�yA)B@:Q�8B+J�5U]`�Ҭ��:���*%Ip9�̀�`
KcQ�Q.B��Ltb��yJ�E�T��7���Am�䢕Ku:��Sji� 5.q%LiF��Tr��i��K�Ҩz�55T%U��U�IՂ�� �Y\"\nS�m���x��Ch�NZ�UZ���( B��\$Y�V��u@蔻����|	�\$\0�\0�oZw2Ҁx2���k\$�*I6I�n�����I,��QU4�\n��).
�Q���aI�]����L�h\"�f���>�:Z�>L�`n�ض��7�VLZu��e��X����B���B�����Z`;���J�]�����S8��f \nڶ�#\$�jM(��ޡ����a�G���+A�!�xL/\0)	C�\n�W@�4�����۩� ��RZ����=���8�`�8~�h��P ��\r�	���D-FyX�+�f�QSj+X�|��9-��s�x�����+�V�cbp쿔o6H�q�����@.��l�8g�YM��WMP��U��YL�3Pa�H2�9��:�a�`
��d\0� &�Y��Y0٘��S�-��%;/�T�BS�P�%f������@�F��(�֍*�q +[�Z:�QY\0޴�J UY֓/���pkzȈ�,�𪇃j�ꀥW�״e�J�F��VBI�\r��pF�Nقֶ�*ը�3k�0�D�{����`q��ҲBq�e�D�
c���V�E���n����FG�E�>j�����0g�a|�Sh�7u �݄�\$���;a��7&��R[WX���(q�#���P���ז�c8!�H���VX�Ď�j��Z������Q,DUaQ�X0��ը���Gb��l�B�t9-oZ���L���­�pˇ�x6&��My��sҐ����\"�̀�R�IWU`c���}l<|�~�w\"��vI%r+��R�\n\\����][��6�&���ȭ�a�Ӻ��j�(ړ�Tѓ� �C'���  '%de,�\n�FC�эe9C�N�Ѝ�-6�Ueȵ��CX��V������+�R+�� ���3B��ڌJ�虜��T2�]�\0P�a�t29��(i�#�aƮ1\"S�:�����oF)k�f���Ъ\0�ӿ��,��w�J@��V򄎵�q.e}KmZ����XnZ {G-���ZQ���}��׶�6ɸ���_�؁Չ�\n�@7�` �C\0]_ ��ʵ����}�G�WW: fCYk+��b۶���2S,	ڋ�9�\0﯁+�W�Z!�e��2�������k.Oc��(v̮8�DeG`ۇ�L���,�d�\"C���B-�İ(����p���p�=����!�k������}(���B�kr�_R�ܼ0�8a%ۘL	\0���b������@�\"��r,�0T�rV>����Q��\"�r��P�&3b�P��-�x���uW~�\"�*舞�N�h�%7���K�Y��^A����C����p����\0�..`c��+ϊ�GJ���H���E����l@|I#Ac��D��|+<[c2�+*WS<�r��g���}��>i�݀�!`f8�(c����Q�=f�\n�2�c�h4�+q���8\na�R�B�|�R����m
��\\q��gX����ώ0�X�`n�F���O p��H�C��jd�f��EuDV��bJɦ��:��\\�!mɱ?,TIa���aT.L�]�,J��?�?��FMct!a٧R�F�G�!�A���rr�-p�X��\r��C^�7���&�R�\0��f�
*�A\n�՛H��y�Y=���l�<��A�_��	+��tA�\0B�<Ay�(fy�1�c�O;p�
��ᦝ`�4СM��*��f�� 5fvy {?���:y��^c��u�'���8\0��ӱ?��g��� 8B��&p9�O\"z���rs�0��B�!u�3�f{�\0�:�\n@\0����p���6�v.;�����b�ƫ:J> ˂��-�B�hkR`-����aw�xEj����r�8�\0\\����\\�Uhm� �(m�H3̴��S����q\0��NVh�Hy�	��5�M͎e\\g�\n�IP:Sj�ۡٶ�<���x�&�L��;nfͶc�q��\$f�&l���i�����0%yΞ�t�/��gU̳�d�\0e:��h�Z	�^�@��1��m#�N��w@��O��zG�\$�m6�6}��ҋ�X'�I�i\\Q�Y���4k-.�:yz���H��]
��x�G��3��M\0��@z7���6�-DO34�ދ\0Κ��ΰ
t\"�\"vC\"Jf�Rʞ��ku3�M��~����5V ��j/3���@gG�}D���B�Nq��=]\$�I��Ӟ�3�x=_j�X٨�fk(C]^j�M��F��ա��ϣCz��V��=]&�\r�A<	��� ���6�Ԯ�״�`jk7:g��4ծ��YZq�ftu�|�h�Z��6��i〰0�?��骭{-7_:��ސtѯ�ck�`Y��&���I�lP
`:�� j�{h�=�f	�
�[by��ʀoЋB�RS���B6��^@'�4��1U�Dq}��N�(X�6j }�c�{@8
���,�	�PFC���B�\$m
v� ��P�\"��L��CS�]����E���lU��f�wh{o�(��)�\0@*a1G� (��D4-c��P8��N|R���VM���n8G`e}�!}���p�����@_���nCt�9��\0]�u��s���~�r��#Cn�p;�%�>wu���n�w��ݞ�. ���[��hT�{��值	�ˁ��J���ƗiJ�6�O�=� �����E��ٴ��Im���V'��@�&�{��������;�op;^��6Ŷ@2�l���N��M��r�_ܰ�Í�` �( y�6�7�����ǂ��7/�p�e>|��	�=�]�oc����&�xNm���烻��o�G�N	p����x��ý���y\\3����'�I`r�G �]ľ�7�\\7�49�]�^p�{<Z��q4�u�|��Qۙ��p���i\$�@ox�_<���9p
BU\"\0005�� i�ׂ��C�p�\n�i@� [��4�jЁ�6b�P�\0�&F2~������U&�}����ɘ	��Da<��zx�k���=���r3��(l_���FeF���4�1�K	\\ӎld�	�1�H\r���p!�%bG�Xf��'\0���	'6��ps_��\$?0\0�~p(�H\n�1�W:9�͢��`��:h�B��g�B�k��p �Ɓ�t��EBI@<�%����` �y�d\\Y@D�P ?�|+!��W��.:  �Le�v,�>q�A�� �: ���bY�@8�d>r/)�B�4�� �(���`|�:t�!����?<�@���/��S��P\0��>\\�� |�3�:V�uw���x�(����4��ZjD^���L�'���C[�'�����jº[�E�� u�{KZ[s���6��S1��z%1�c��B4�B\n3M`0�;����3�.�&?��!YA�I,)��l�W['��ITj���>F���S���BбP�ca�ǌu�N����H�	LS��0��Y`���\"il�\r�B���/����%P���N�G��0J�X\n?a�!�3@M�F&ó����,�\"���lb�:KJ\r�`k_�b��A��į��1�
I,�����;B,�:���Y%�J���#v��'�{������	wx:\ni����}
c��eN���`!w��\0�BRU#�S�!�<`��&v�<�&�qO�+Σ�sfL9�Q�Bʇ����b��_+�*�Su>%0�����8@l�?�L1po.�C&��ɠB��qh�����z\0�`1�_
9�\"���!�\$���~~-�.�*3r?�ò�d�s\0 ����>z\n�\0�0�1  �~���J����|Sޜ��k7g�\0��KԠd��a��Pg�%�w�D��zm�����)����j�����`k���Q�^��1���+��>/wb�GwOk���_�'��-CJ��7&����E�\0L\r>�!�q́���7����o��`9O`�����+!}�P~E�N�c��Q� )��#��#�����������J��z_u{��K%�\0=��O�X�߶C�>\n���|w�?� F�����a�ϩU����b	N�Y��h����/��)�G��2���K|�y/�\0��Z�{��P�YG�;�?Z}T!�0��=mN����f�\"%4�a�\"!�ޟ����\0���}��[��ܾ��bU}�ڕm��2�����/t���%#�.�ؖ��se�B�p&}[˟��7�<a�K���8��P\0��g��?��,�\0�߈r,�>���W����/��[�q��k~�CӋ4��G��:��X��G�r\0������L%VFLUc��䑢��H�ybP��'#��	\0п���`9�9�~���_��0q�5K-�E0�b�ϭ�����t`lm����b��Ƙ; ,=��
'S�.b��S���Cc����ʍAR,����X�@�'��8Z0�&�Xnc<<ȣ�3\0(�+*�3��@&\r�+�@h, ��\$O���\0Œ��t+>����b��ʰ�\r�><]#�%�;N�s�Ŏ����*��c�0-@��L� >�Y�p#�-�f0��ʱa�,>��`����P�:9��o��
�ov�R)e\0ڢ\\����\nr{îX����:A*��.�D��7�����#,�N�\r�E���hQK2�ݩ��z�>P@��
�	T<��=�:���X�GJ<�GAf�&�A^p�`���{��0`�:���);U !�e\0����c�p\r�����:(��@�%2	S�\$Y��3�h C��:O�#��L��/����k,��K�oo7�BD0{���j��j&X2��{�}�R�x��v���أ�9A��

��
0�;0���� �-�5��/�<�� �N�8E����	+�Ѕ�Pd��;���*n��&�8/jX�\r��>	PϐW>K ��O��V�/��U\n<��\0�\nI�k@��㦃[��Ϧ²�#�?���%���.\0001\0��k�`1T
� ����ɐl�������p���������< .�>��5��\0��	O�>k@Bn��<\"i%�>��z��������3�P�!�\r�\"��\r �>�ad���U?�ǔ3P��j3�䰑>;���>�t6�2�[��޾M\r�>��\0��P���B�Oe*R�n���y;� 8\0���o�0���i���3ʀ2@����?x�[����L�a����w\ns����A��x\r[�a�6�clc=�ʼX0�z/>+����W[�o2���)e�2�HQP�DY�zG4#YD����p)	�H�p���&�4*@�/:�	�T�	���aH5���h.�A>��`;.���Y��a	���t/ =3��BnhD?(\n�!�B�s�\0��D�&D�J��)\0�j�Q�y��hDh(�K�/!�>�h,=�����tJ�+�S��,\"M�Ŀ�N�1�[;�Т��+��#<��I�Zğ�P�)��LJ�D��P1\$����Q�>dO��v�#�/mh8881N:��Z0Z���T �B�C�q3%��@�\0��\"�XD	�3\0�!\\�8#�h�v�ib��T�!d�����V\\2��S��Œ\nA+ͽp�x�iD(�(�<*��+��E� �T���B�S�CȿT
���� e�A�\"�|�u�v8�T\0002�@8D^oo�����|�N������J8[��3����J�z׳WL\0�\0��Ȇ8�:y,�6&@�� �E�ʯݑh;�!f��.B�;:���[Z3������n���ȑ��A���qP4,��Xc8^��`׃��l.����S�hޔ���O+�%P#Ρ\n?��IB��eˑ�O\\]��6�#��۽؁(!c)�N����?E��B##D �Ddo��P�A�\0�:�n�Ɵ�`  ��Q��>!\r6 �\0��V%cb�HF�)�m&\0B�2I�5��#]���D>��3<\n:ML��9C���0��\0���(ᏩH\n����M�\"GR\n@���`[���\ni*\0��)������u�)��Hp\0�N�	�\"��N:9q�.\r!���J��{,�'����4�
B���lq� ��Xc��4��N1ɨ5�Wm��3\n��F��`�'��Ҋx��&>z>N�\$4?����(\n쀨>�	�ϵP�!Cq͌��p�qGLqq�G�y�H.�^��\0z�\$�AT9Fs�Ѕ�D{�a��cc_�G�z�)� �}Q��h��HBָ�<�y!L����!\\�����'�H(��-�\"�in] Ğ���\\�!�`M�H,gȎ��*�Kf�*\0�>6���6��2�hJ�7�{nq�8����H�#c� H�#�\r�:��7�8�܀Z��ZrD��߲`rG\0�l\n�I��i\0<����\0Lg�~���E��\$��P�\$�@�PƼT03�HGH�l�Q%*\"N?�%��	��\n�CrW�C\$��p�%�uR`��%��R\$�<�`�Ifx���\$/\$�����\$���O�(���\0��\0�RY�*�/	�\rܜC9��&hh�=I�'\$�RRI�'\\�a=E����u·'̙wI�'T���������K9%�d����!��������j�����&���v̟�\\=<,�E��`�Y��\\����*b0>�r��,d�pd���0DD ̖`�,T �1�% P���/�\r�b�(���J����T0�``ƾ��
��J�t���ʟ((d�ʪ�h+ <Ɉ+H%i
�����#�`� ���'��B>t��J�Z\\�`<J�+hR���8�hR�,J]g�I��0\n%J�*�Y���JwD��&ʖD�������R�K\"�1Q�� ��AJKC,�mV�������-���KI*�r��\0�L�\"�Kb(����J:qKr�d�ʟ-)��ˆ#Ը�޸[�A�@�.[�Ҩʼ�4���.�1�J�.̮�u#J���g\0��򑧣<�&���K�+�	M?�/d��%'/��2Y��>�\$��l�\0��+����}-t��ͅ*�R�\$ߔ��K�.����JH�ʉ
�2\r��B���(P���6\"��nf�\0#Ї ��%\$��[�\n�no�LJ�����e'<����1K��y�Y1��s�0�&zLf#�Ƴ/%y-�ˣ3-��K��L�΁��0����[,��̵,������0���(�.D��
@��2�L+.|�����2�(�L�*��S:\0�3����G3l��aːl�@L�3z4�ǽ%̒�L�3��� �!0�33=L�4|ȗ��+\"���4���7�,\$�SPM�\\��?J�Y�̡��+(�a=K��4���C̤<Ё�=\$�,��UJ]5h�W�&t�I%��5�ҳ\\M38g�́5H�N?W1H��^��Ը�Y͗ؠ�͏.�N3M�4Å�`��i/P�7�dM>�d�/�LR���=K�60>�I\0[��\0��\r2���Z@�1��2��7�9�FG+�Ҝ�\r)�hQtL}8\$�BeC#��r*H�۫�-�H�/���6��\$�RC9�ب!���7�k/P�0Xr5��3D���<T�Ԓq�K���n�H�<�F�:1SL�r�%(��u)�Xr�1��nJ�I��S�
\$\$�.·9��IΟ �3 �L�l���Ι9��C�N�#ԡ�\$�/��s��9� @6�t���N�9���N�:����7�Ӭ�:D���M)<#���M}+�2�N��O &��JNy*���ٸ[;���O\"m����M�<c�´���8�K�,���N�=07s�JE=T��O<����J�=D��:�C<���ˉ=���K�ʻ̳�L3�����LTЀ3�S,�.���q-��s�7�>�?�7O;ܠ`�OA9���ϻ\$���
O�;��`9�n�I�A�xp��E=O�<��5����2�O�?d�����`N�iO�>��3�P	?���O�m��S�M�ˬ��=�(�d�Aȭ9���\0�#��@��9D����&���
?����i9�\n�/��A���ȭA��S�Po?kuN5�~4���6���=򖌓*@(�N\0\\۔d
G��p#��>�0��\$2�4z )�
`�W���+\0��80�菦�
�����z\"T��0�:\0�\ne \$��rM�=�r\n�N�P�Cm
t80�� #��J=�&��
3\0*��B�6�\"������#��>�	�(Q\n���8�1C\rt2�EC�\n`(�x?j8N�\0��[��QN>���'\0�x	c���\n�3��Ch�`&\0���8�\0�\n���O`/����A`#��Xc���D �tR\n>���d�B�D�L��������Dt4���j�p�G AoQoG8,-s����K#�);�E5�TQ�G�4Ao\0�>�tM�D8yR G@'P�C�	�<P�C�\"�K\0��x��~\0�e
i9���v))ѵGb6���H\r48�@�M�:��F�tQ�!H��{R
} �URp���O\0�I�t8������[D4F�D�#��+D�'�M����>RgI���Q�J���U�)Em���TZ�E�'��iE����qFzA��>�)T�Q3H�#TL�qIjNT���&C��h�X\nT���K\0000�5���JH�\0�FE@'љFp�hS5F�\"�oѮ�e%aoS E)� ��DU��Q�Fm�ѣM��Ѳe(tn� �U1ܣ~>�\$��ǂ��(h�ǑG�y`�\0��	��G��3�5Sp(��P�G�\$��#��	���N�\n�V\$��]ԜP�=\"RӨ?Lzt��1L\$\0��G~��,�KN�=���GM����NS�)��O]:ԊS}�81�RGe@C�\0�OP�S�N�1��T!P�@��S����S�G`\n�:��P�j�7R� @3��\n� �����
��DӠ��L�����	��\0�Q5���CP��SMP�v4��?h	h�T�D0��֏��>&�ITx�O�?�@U��R8@%Ԗ��K���N�K��RyE�E#�� @����%L�Q�Q����?N5\0�R\0�ԁT�F�ԔR�S�!oTE�C(�����ĵ\0�?3i�SS@ U�QeM��	K�\n4P�CeS��\0�NC�P��O�!�\"RT�����S�N���U5OU>UiI�PU#UnKP��UYT�*�C��U�/\0+���)��:ReA�\$\0���x� �WD�3���`����U5�IHUY��:�P	�e\0�MJi���
��Q�>�@�T�C{��u��?�^�v\0WR�]U}C��1-5+U�?�\r�W<�?5�JU-SX��L�� \\t�?�sM�b�ՃV܁t�T�>�MU+�	E�c���9Nm\rRǃC�8�S�X�'R��XjCI#G|�!Q�Gh�t�Q��� )<�Y�*��RmX0����M���OQ�Y�h���du���Z(�Ao#�NlyN�V�Z9I���M��V�ZuOՅT�T�EՇַS�e����\n�X��S�QER����[MF�V�O=/����>�gչT�V�oU�T�Z�N�*T\\*����S-p�S��V�q��M(�Q=\\�-UUUV�C���Z�\nu�V\$?M@U�WJ\r\rU��\\�'U�W]�W��W8�N�'#h=oC���F(��:9�Yu����V-U�9�]�C�:U�\\�\n�qW���(TT?5P�\$ R3�⺟C}`>\0�E]�#R��	��#R�)� W���:`#�G�)4�R��;��ViD%8�)Ǔ^�Q��#�h	�HX	��\$N�x��#i x�ԒXR��'�9`m\\���\nE��Q�`�bu@��N�dT�#YY����GV�]j5#?L�xt/#���#酽O�P��Q��6����^� �������M\\R5t�Ӛp�*��X�V\"W�D�	oRALm\rdG�N	����6�p\$�P废E5����Tx\n�+��C[��V�����8U�Du}ػF\$.��Q-;4Ȁ�NX\n�.X�b͐�\0�b�)�#�N�G4K��ZS�^״M�8��d�\"C��>��dHe\n�Y8���.� ���ҏF�D��W1cZ6��Q�KH�@*\0�^���\\Q�F�4U3Y|�=�Ӥ�E
��ۤ�?-�47Y�Pm�hYw_\r�VeױM���ُe(0� �F�\r�!�PUI�u�7Q�C�ю?0����gu\rqधY-Q�����=g\0�\0M#�U�S5Zt�֟ae^�\$>�ArV�_\r;t���HW�Z�@H��hzD��\0�S2J� HI�O�'ǁe�g�6�[�R�<�?�
 /��KM����\n>��H�Z!i�
���TX6���i�C !ӛg�
� �G }Q6��4>�w�!ڙC}�VB�>�UQڑj�8c�U�T���'<�>����HC]�V��7jj3v���`0���23����x�@U�k�\n�:Si5��#Y�-w����M?c��MQ�GQ�уb`��\0�@
��ҧ\0M��)ZrKX�֟�Wl������l�TM�D\r4�QsS�40�sQ́�mY�h�d� �C`{�V �gE�\n��XkՁ�'��,4���^��6�#<4��NX
nM):��OM_6d�������[\"KU�n��?l�x\0&\0�R56�T~>�
�ո?�Jn��� ��Z/i�6���glͦ�U��F}�.����JL�CTbM�4��cL�TjSD�}Jt���Z����:�L���d:�Ez�ʤ�>��V\$2>����[�p�6��R�9u�W.?�1��RHu���R�?58Ԯ��D��u���p�c�Z�?�r׻ Eaf��}5wY���ϒ���W�wT[Sp7'�_aEk�\"[/i��#�\$;m�fأWO����F�\r%\$�ju-t#<�!�\n:�KEA����]�\nU�Q�KE��#��X��5[�>�`/��D��֭VEp
�)��I%�q���n�x):��le���[e�\\�eV[j�����7 -+��G�WEwt�WkE�~u�Q/m�#ԐW�`�yu�ǣD�A�'ױ\r��ՙO�D )Z M^��u-|v8]�g��h���L��W\0���6�X��=Y�d�Q�7
ϓ��9����r <�֏�D��B`c�9���`�D
�=wx�I%�,ᄬ�����j[њ����O��� ``��|�����������.�	AO���	��@�@ 0h2�\\�ЀM{e�9^>���@7\0��˂W���\$,��Ś�@؀����w^fm�,\0�yD,ם^X�.�ֆ�7����2��f;��6�\n����^�zC�קmz��n�^���&LFF�,��[��e�
�aXy9h�!:z�9c�Q9b� !���Gw_W�g�9���S+t���p�tɃ\nm+����_�	��\\���k5���]�4�_h�9 ��N����]%|��7�֜�];��
|���X��9�|����G���[��\0�}U���MC�I:�qO�Vԃa\0\r�R�6π�\0�@H
��P+r�S�W� ��p7�I~�p/��H�^������E�-%��̻�&.��+�Jђ;:���!���N�	�~����/�W��
!�B�L+�\$��q�=��+�`/Ƅe�\\���x�pE�lpS�JS�ݢ��6��_�(ů���b\\O��&�\\�59�\0�9n���D�{�\$���K��v2	d]�v�C�����?�tf|W�:���p&��Ln��賞�{;���G�R9��T.y���I8���\rl� �	T�
�n�3���T.�9��3����Z�s����G����:	0���z��.�]��ģQ�?�gT�%��x�Ռ.����n<�-�8B˳,B��rgQ�����Ɏ`��2�:{�g��s��g�Z��� ׌<��w{���bU9�	`5`4�\0BxMp�8qnah�@ؼ�-�(�>S|0�����3�8h\0���C�zLQ�@�\n?��`A��>2��,���N�&��x�l8sah1�|�B�ɇD�xB�#V��V�׊`W�a'@���	X_?\n�  �_�. �P�r2�bUar�I�~��S���\0ׅ\"�2����>b;�vPh{[
�7a`�\0�˲j�o�~���v��|fv� 4[�\$��{�P\rv�BKGbp������O�5ݠ2\0j�لL���)�m��V�ejBB.'R{C��V'`؂ ��%�ǀ�\$�O��\0�`����4 �N�>;4���/�π��*��\\5���!��`X*�%��N�3S�AM���Ɣ,�1����\\��caϧ ��@��˃�B/����0`�v2��`hD�JO\$�@p!9�
!�\n1�7pB,>8F4��f�π:��7���3��3����T8�=+~�n���\\�e�<br����Fز� ��C�N�:c�:�l�<\r��\\3�>���6�ONn��!;��@�tw�^F�L�;��
�,^a��\ra\"��ڮ'�:�v�Je4�א;��_d\r4\r�:����S�����2��[c��X�ʦPl�\$�ޣ�i�w�d#�B��b��������`:���~ <\0�2����R���P�\r�J8D�t@�E��\0\r͜6����7����Y���\"����\r�����3��.�+�z3�;_ʟvL����wJ�94�I�Ja,A����;�s?�N\nR��!��ݐ�Om�s�_��-zۭw���zܭ7���z���M����o����\0��a��ݹ4�8�Pf�Y�?��i��eB�S�1\0�jDTeK��UYS�?66R	�c�
6Ry[c���5�]B͔�R�_eA)&�[凕XYRW�6VYaeU�fYe�w��U�b�w�E�ʆ;z�^W�9��ק�ݖ��\0<ޘ�e�9S���da�	�_-��L�8ǅ�Q��TH[!<p\0��Py5�|�#��P�	�9v��2�|Ǹ��fao��,j8�\$A@k����a���b�c��f4!4���cr,;�����b�=��;\0��ź���cd��X�b�x�a�Rx0A�h�+w�xN[��B� �p���w�T�8T%��M�l2�������}��s.kY��0\$/�fU�=��s�gK���M� �?���`4c.��!�&�分g��f�/�f1�=��V AE<#̹�f\n�)���Np��`.\"\"�A�����
q��X��٬:a�8��f��Vs�G��r�:�V��c�g�Vl��g=��`��W���y�gU��˙�Ẽ�eT=�����x 0� M�@����%κb���w��f��O�筘�*0���|t�%��P��p��gK���?p�@J�<Bٟ#�`1��9�2�g�!3~����nl��f��Vh���.����aC���?���-�1�68>A� �a�\r��y�0��i�J�}��
�����
z:\r�)�S���@
��h@���Y��� mCEg�cyφ��<���h@�@�zh<W��`��:zO���\r��W���V08�f7�(Gy���`St#��f�#����C(9���؀d���8T:���0�� q���79��phAg�6�.��7Fr�b� �j��A5��a1�
�h�ZCh:�%��gU��D9��Ɉ�׹��0~vTi;�VvS��w��\r΃?��f �����n�ϛiY��a��3�·9�,\n��r��,/,@.:�Y>&��F�)�����}�b���iO�i��:d�A�n��c=�L9O�h{�� 8hY.������������\r��և�����1Q�U	�C�h��e�O���+2o����N�����zp�(�]�h��Z|�O�c�zD���;�T\0j�\0�8#�>Ύ�=bZ8Fj���;�޺T酡w��)���N`���ÅB{��z\r�c���|dTG�i�/��
!i��0���'`Z:�CH�(8�`V������\0�ꧩ��W��Ǫ��zgG������-[��	i��N\rq��n���o	ƥfEJ��apb��}6���=o���,t�Y+��EC\r�Px4=����@���.��F��[�zq���X6:FG��#��\$@&�ab��hE:����`�S�1�1 g1���2uhY��_:Bߡdc�*���\0�ƗFYF�:���n���=ۨH*Z�Mhk�/�냡�zٹ]��h@����1\0��ZK�������^+�,vf�s��>���O�|���s�\0֜5�X
��ѯF��n�A�r]|�Ii4�� ��C� h@ع����cߥ�6smO������gX�V2�6g?~��Y�Ѱ�s�cl \\R�\0��c��A+�1������\n(����^368cz:=z��(�� ;裨�s�F�@`;�,>yT��&��d�Lן��%��- �CHL8\r��b�����Mj]4�Ym9����Z�B��P}<���X���̥�+g�^�M� + B_Fd�X���l�w�~�\r⽋�\":��qA1X������3�ΓE�h�4�ZZ��&����1~!N�f��o���\nMe�଄��XI΄�G@V*X��;�Y5{V�\n���T�z\rF�3}m
��p1�[�>�t�e�w����@V�z#��2��	i���{�9��p̝�gh���+[elU���A�ٶӼi1�!��omm�*K���}��!�Ƴ����{me�f`��m��C�z=�n�:}g� T�mLu1F��}=8�Z���O��mFFMf��OO����������/����ޓ���V�oqj���n!+����Z��I�.�9!nG�\\��3a�~�O+��::�K@�\n�@���Hph��\\B��dm�fvC���P�\" ��.nW&��n��HY�+\r���z�i>Mfqۤ��Qc�[�H+��o��*�1'��#āEw�D_X�)>�s��- ~\rT=�������- �y�m����{�h��j�M�)�^����'@V�+i�������;F��D[�b!����B	��:MP���ۭoC�vAE?�C�IiY��#�p�P\$k�J�q�.�07���x�l�sC|���bo�2�X�>M�\rl&��:2�~��cQ����o��d�-��U�Ro�Y�nM;�n�#��\0�P�f��Po׿(C�v<���[�o۸����fѿ���;�ẖ�[�Y�.o�Up���pU���.���B!'\0���<T�:1����� ��<���n��F���I�ǔ��V0�ǁRO8�w��,aF��ɥ�[�Ο��YO����/\0��ox���Q�?��:ً���`h@:�����/M�m�x:۰c1������v�
;���^���@��@�� ���\n{�����;���B���8�� g坒�\\*g�yC)��E�^�O�h	���A�u>���@�D��Y�����`o�<>��p���ķ�q,Y1Q��߸��/qg�\0+\0���D���?�� ����k:�\$����ץ6~I��=@���!��v�zO񁚲�+���9�i����a������g������?��0Gn�q�]{Ҹ,F���O���� <_>f+ ��,��	���&�����·�y�ǩO�:�U¯�L�\n�úI:2��-;_Ģ�|%�崿!��f�\$���Xr\"Kni����\$8#�g�t-��r@L�圏�@S�<�rN\n�D/rLdQk࣓�����e����Э��\n= 4)�
B���ך�");}else{header("Content-Type: image/gif");switch($_GET["file"]){case"plus.gif":echo"GIF89a\0\0�\0001���\0\0����\0\0\0!�\0\0\0,\0\0\0\0\0\0!�����M��*)�o��) q��e���#��L�\0;";break;case"cross.gif":echo"GIF89a\0\0�\0001���\0\0����\0\0\0!�\0\0\0,\0\0\0\0\0\0#�����#\na�Fo~y�.�_wa��1�J�
G�L�6]\0\0;";break;case"up.gif":echo"GIF89a\0\0�\0001���\0\0����\0\0\0!�\0\0\0,\0\0\0\0\0\0 �����MQN\n�}��a8�y�aŶ�\0��\0;";break;case"down.gif":echo"GIF89a\0\0�\0001���\0\0����\0\0\0!�\0\0\0,\0\0\0\0\0\0 �����M��*)�[W�\\��L&ٜƶ�\0��\0;";break;case"arrow.gif":echo"GIF89a\0\n\0�\0\0������!�\0\0\0,\0\0\0\0\0\n\0\0�i������Ӳ޻\0\0;";break;}}exit;}if($_GET["script"]=="version"){$p=file_open_lock(get_temp_dir()."/adminer.version");if($p)file_write_unlock($p,serialize(array("signature"=>$_POST["signature"],"version"=>$_POST["version"])));exit;}global$b,$e,$j,$Gb,$Nb,$Xb,$k,$Ac,$Ec,$ba,$Xc,$y,$ca,$nd,$je,$Ne,$dg,$Jc,$T,$Lg,$Rg,$Yg,$ga;if(!$_SERVER["REQUEST_URI"])$_SERVER["REQUEST_URI"]=$_SERVER["ORIG_PATH_INFO"];if(!strpos($_SERVER["REQUEST_URI"],'?')&&$_SERVER["QUERY_STRING"]!="")$_SERVER["REQUEST_URI"].="?$_SERVER[QUERY_STRING]";if($_SERVER["HTTP_X_FORWARDED_PREFIX"])$_SERVER["REQUEST_URI"]=$_SERVER["HTTP_X_FORWARDED_PREFIX"].$_SERVER["REQUEST_URI"];$ba=($_SERVER["HTTPS"]&&strcasecmp($_SERVER["HTTPS"],"off"))||ini_bool("session.cookie_secure");@ini_set("session.use_trans_sid",false);if(!defined("SID")){session_cache_limiter("");session_name("adminer_sid");$Ee=array(0,preg_replace('~\?.*~','',$_SERVER["REQUEST_URI"]),"",$ba);if(version_compare(PHP_VERSION,'5.2.0')>=0)$Ee[]=true;call_user_func_array('session_set_cookie_params',$Ee);session_start();}remove_slashes(array(&$_GET,&$_POST,&$_COOKIE),$rc);if(get_magic_quotes_runtime())set_magic_quotes_runtime(false);@set_time_limit(0);@ini_set("zend.ze1_compatibility_mode",false);@ini_set("precision",15);function
get_lang(){return'en';}function
lang($Kg,$ae=null){if(is_array($Kg)){$Qe=($ae==1?0:1);$Kg=$Kg[$Qe];}$Kg=str_replace("%d","%s",$Kg);$ae=format_number($ae);return
sprintf($Kg,$ae);}if(extension_loaded('pdo')){class
Min_PDO
extends
PDO{var$_result,$server_info,$affected_rows,$errno,$error;function
__construct(){global$b;$Qe=array_search("SQL",$b->operators);if($Qe!==false)unset($b->operators[$Qe]);}function
dsn($Kb,$V,$G,$pe=array()){try{parent::__construct($Kb,$V,$G,$pe);}catch(Exception$cc){auth_error(h($cc->getMessage()));}$this->setAttribute(13,array('Min_PDOStatement'));$this->server_info=@$this->getAttribute(4);}function
query($I,$Sg=false){$J=parent::query($I);$this->error="";if(!$J){list(,$this->errno,$this->error)=$this->errorInfo();if(!$this->error)$this->error='Unknown error.';return
false;}$this->store_result($J);return$J;}function
multi_query($I){return$this->_result=$this->query($I);}function
store_result($J=null){if(!$J){$J=$this->_result;if(!$J)return
false;}if($J->columnCount()){$J->num_rows=$J->rowCount();return$J;}$this->affected_rows=$J->rowCount();return
true;}function
next_result(){if(!$this->_result)return
false;$this->_result->_offset=0;return@$this->_result->nextRowset();}function
result($I,$l=0){$J=$this->query($I);if(!$J)return
false;$L=$J->fetch();return$L[$l];}}class
Min_PDOStatement
extends
PDOStatement{var$_offset=0,$num_rows;function
fetch_assoc(){return$this->fetch(2);}function
fetch_row(){return$this->fetch(3);}function
fetch_field(){$L=(object)$this->getColumnMeta($this->_offset++);$L->orgtable=$L->table;$L->orgname=$L->name;$L->charsetnr=(in_array("blob",(array)$L->flags)?63:0);return$L;}}}$Gb=array();class
Min_SQL{var$_conn;function
__construct($e){$this->_conn=$e;}function
select($Q,$N,$Z,$s,$re=array(),$_=1,$F=0,$Xe=false){global$b,$y;$ed=(count($s)<count($N));$I=$b->selectQueryBuild($N,$Z,$s,$re,$_,$F);if(!$I)$I="SELECT".limit(($_GET["page"]!="last"&&$_!=""&&$s&&$ed&&$y=="sql"?"SQL_CALC_FOUND_ROWS ":"").implode(", ",$N)."\nFROM ".table($Q),($Z?"\nWHERE ".implode(" AND ",$Z):"").($s&&$ed?"\nGROUP BY ".implode(", ",$s):"").($re?"\nORDER BY ".implode(", ",$re):""),($_!=""?+$_:null),($F?$_*$F:0),"\n");$Yf=microtime(true);$K=$this->_conn->query($I);if($Xe)echo$b->selectQuery($I,$Yf,!$K);return$K;}function
delete($Q,$ff,$_=0){$I="FROM ".table($Q);return
queries("DELETE".($_?limit1($Q,$I,$ff):" $I$ff"));}function
update($Q,$P,$ff,$_=0,$If="\n"){$ih=array();foreach($P
as$z=>$X)$ih[]="$z = $X";$I=table($Q)." SET$If".implode(",$If",$ih);return
queries("UPDATE".($_?limit1($Q,$I,$ff,$If):" $I$ff"));}function
insert($Q,$P){return
queries("INSERT INTO ".table($Q).($P?" (".implode(", ",array_keys($P)).")\nVALUES (".implode(", ",$P).")":" DEFAULT VALUES"));}function
insertUpdate($Q,$M,$We){return
false;}function
begin(){return
queries("BEGIN");}function
commit(){return
queries("COMMIT");}function
rollback(){return
queries("ROLLBACK");}function
slowQuery($I,$zg){}function
convertSearch($Rc,$X,$l){return$Rc;}function
value($X,$l){return(method_exists($this->_conn,'value')?$this->_conn->value($X,$l):(is_resource($X)?stream_get_contents($X):$X));}function
quoteBinary($_f){return
q($_f);}function
warnings(){return'';}function
tableHelp($E){}}$Gb=array("server"=>"MySQL")+$Gb;if(!defined("DRIVER")){$Te=array("MySQLi","MySQL","PDO_MySQL");define("DRIVER","server");if(extension_loaded("mysqli")){class
Min_DB
extends
MySQLi{var$extension="MySQLi";function
__construct(){parent::init();}function
connect($O="",$V="",$G="",$sb=null,$Pe=null,$Rf=null){global$b;mysqli_report(MYSQLI_REPORT_OFF);list($Oc,$Pe)=explode(":",$O,2);$Xf=$b->connectSsl();if($Xf)$this->ssl_set($Xf['key'],$Xf['cert'],$Xf['ca'],'','');$K=@$this->real_connect(($O!=""?$Oc:ini_get("mysqli.default_host")),($O.$V!=""?$V:ini_get("mysqli.default_user")),($O.$V.$G!=""?$G:ini_get("mysqli.default_pw")),$sb,(is_numeric($Pe)?$Pe:ini_get("mysqli.default_port")),(!is_numeric($Pe)?$Pe:$Rf),($Xf?64:0));$this->options(MYSQLI_OPT_LOCAL_INFILE,false);return$K;}function
set_charset($La){if(parent::set_charset($La))return
true;parent::set_charset('utf8');return$this->query("SET NAMES $La");}function
result($I,$l=0){$J=$this->query($I);if(!$J)return
false;$L=$J->fetch_array();return$L[$l];}function
quote($cg){return"'".$this->escape_string($cg)."'";}}}elseif(extension_loaded("mysql")&&!((ini_bool("sql.safe_mode")||ini_bool("mysql.allow_local_infile"))&&extension_loaded("pdo_mysql"))){class
Min_DB{var$extension="MySQL",$server_info,$affected_rows,$errno,$error,$_link,$_result;function
connect($O,$V,$G){if(ini_bool("mysql.allow_local_infile")){$this->error=sprintf('Disable %s or enable %s or %s extensions.',"'mysql.allow_local_infile'","MySQLi","PDO_MySQL");return
false;}$this->_link=@mysql_connect(($O!=""?$O:ini_get("mysql.default_host")),("$O$V"!=""?$V:ini_get("mysql.default_user")),("$O$V$G"!=""?$G:ini_get("mysql.default_password")),true,131072);if($this->_link)$this->server_info=mysql_get_server_info($this->_link);else$this->error=mysql_error();return(bool)$this->_link;}function
set_charset($La){if(function_exists('mysql_set_charset')){if(mysql_set_charset($La,$this->_link))return
true;mysql_set_charset('utf8',$this->_link);}return$this->query("SET NAMES $La");}function
quote($cg){return"'".mysql_real_escape_string($cg,$this->_link)."'";}function
select_db($sb){return
mysql_select_db($sb,$this->_link);}function
query($I,$Sg=false){$J=@($Sg?mysql_unbuffered_query($I,$this->_link):mysql_query($I,$this->_link));$this->error="";if(!$J){$this->errno=mysql_errno($this->_link);$this->error=mysql_error($this->_link);return
false;}if($J===true){$this->affected_rows=mysql_affected_rows($this->_link);$this->info=mysql_info($this->_link);return
true;}return
new
Min_Result($J);}function
multi_query($I){return$this->_result=$this->query($I);}function
store_result(){return$this->_result;}function
next_result(){return
false;}function
result($I,$l=0){$J=$this->query($I);if(!$J||!$J->num_rows)return
false;return
mysql_result($J->_result,0,$l);}}class
Min_Result{var$num_rows,$_result,$_offset=0;function
__construct($J){$this->_result=$J;$this->num_rows=mysql_num_rows($J);}function
fetch_assoc(){return
mysql_fetch_assoc($this->_result);}function
fetch_row(){return
mysql_fetch_row($this->_result);}function
fetch_field(){$K=mysql_fetch_field($this->_result,$this->_offset++);$K->orgtable=$K->table;$K->orgname=$K->name;$K->charsetnr=($K->blob?63:0);return$K;}function
__destruct(){mysql_free_result($this->_result);}}}elseif(extension_loaded("pdo_mysql")){class
Min_DB
extends
Min_PDO{var$extension="PDO_MySQL";function
connect($O,$V,$G){global$b;$pe=array(PDO::MYSQL_ATTR_LOCAL_INFILE=>false);$Xf=$b->connectSsl();if($Xf){if(!empty($Xf['key']))$pe[PDO::MYSQL_ATTR_SSL_KEY]=$Xf['key'];if(!empty($Xf['cert']))$pe[PDO::MYSQL_ATTR_SSL_CERT]=$Xf['cert'];if(!empty($Xf['ca']))$pe[PDO::MYSQL_ATTR_SSL_CA]=$Xf['ca'];}$this->dsn("mysql:charset=utf8;host=".str_replace(":",";unix_socket=",preg_replace('~:(\d)~',';port=\1',$O)),$V,$G,$pe);return
true;}function
set_charset($La){$this->query("SET NAMES $La");}function
select_db($sb){return$this->query("USE ".idf_escape($sb));}function
query($I,$Sg=false){$this->setAttribute(1000,!$Sg);return
parent::query($I,$Sg);}}}class
Min_Driver
extends
Min_SQL{function
insert($Q,$P){return($P?parent::insert($Q,$P):queries("INSERT INTO ".table($Q)." ()\nVALUES ()"));}function
insertUpdate($Q,$M,$We){$d=array_keys(reset($M));$Ue="INSERT INTO ".table($Q)." (".implode(", ",$d).") VALUES\n";$ih=array();foreach($d
as$z)$ih[$z]="$z = VALUES($z)";$gg="\nON DUPLICATE KEY UPDATE ".implode(", ",$ih);$ih=array();$ud=0;foreach($M
as$P){$Y="(".implode(", ",$P).")";if($ih&&(strlen($Ue)+$ud+strlen($Y)+strlen($gg)>1e6)){if(!queries($Ue.implode(",\n",$ih).$gg))return
false;$ih=array();$ud=0;}$ih[]=$Y;$ud+=strlen($Y)+2;}return
queries($Ue.implode(",\n",$ih).$gg);}function
slowQuery($I,$zg){if(min_version('5.7.8','10.1.2')){if(preg_match('~MariaDB~',$this->_conn->server_info))return"SET STATEMENT max_statement_time=$zg FOR $I";elseif(preg_match('~^(SELECT\b)(.+)~is',$I,$C))return"$C[1] /*+ MAX_EXECUTION_TIME(".($zg*1000).") */ $C[2]";}}function
convertSearch($Rc,$X,$l){return(preg_match('~char|text|enum|set~',$l["type"])&&!preg_match("~^utf8~",$l["collation"])&&preg_match('~[\x80-\xFF]~',$X['val'])?"CONVERT($Rc USING ".charset($this->_conn).")":$Rc);}function
warnings(){$J=$this->_conn->query("SHOW WARNINGS");if($J&&$J->num_rows){ob_start();select($J);return
ob_get_clean();}}function
tableHelp($E){$_d=preg_match('~MariaDB~',$this->_conn->server_info);if(information_schema(DB))return
strtolower(($_d?"information-schema-$E-table/":str_replace("_","-",$E)."-table.html"));if(DB=="mysql")return($_d?"mysql$E-table/":"system-database.html");}}function
idf_escape($Rc){return"`".str_replace("`","``",$Rc)."`";}function
table($Rc){return
idf_escape($Rc);}function
connect(){global$b,$Rg,$dg;$e=new
Min_DB;$lb=$b->credentials();if($e->connect($lb[0],$lb[1],$lb[2])){$e->set_charset(charset($e));$e->query("SET sql_quote_show_create = 1, autocommit = 1");if(min_version('5.7.8',10.2,$e)){$dg['Strings'][]="json";$Rg["json"]=4294967295;}return$e;}$K=$e->error;if(function_exists('iconv')&&!is_utf8($K)&&strlen($_f=iconv("windows-1250","utf-8",$K))>strlen($K))$K=$_f;return$K;}function
get_databases($tc){$K=get_session("dbs");if($K===null){$I=(min_version(5)?"SELECT SCHEMA_NAME FROM information_schema.SCHEMATA ORDER BY SCHEMA_NAME":"SHOW DATABASES");$K=($tc?slow_query($I):get_vals($I));restart_session();set_session("dbs",$K);stop_session();}return$K;}function
limit($I,$Z,$_,$ce=0,$If=" "){return" $I$Z".($_!==null?$If."LIMIT $_".($ce?" OFFSET $ce":""):"");}function
limit1($Q,$I,$Z,$If="\n"){return
limit($I,$Z,1,0,$If);}function
db_collation($i,$Xa){global$e;$K=null;$g=$e->result("SHOW CREATE DATABASE ".idf_escape($i),1);if(preg_match('~ COLLATE ([^ ]+)~',$g,$C))$K=$C[1];elseif(preg_match('~ CHARACTER SET ([^ ]+)~',$g,$C))$K=$Xa[$C[1]][-1];return$K;}function
engines(){$K=array();foreach(get_rows("SHOW ENGINES")as$L){if(preg_match("~YES|DEFAULT~",$L["Support"]))$K[]=$L["Engine"];}return$K;}function
logged_user(){global$e;return$e->result("SELECT USER()");}function
tables_list(){return
get_key_vals(min_version(5)?"SELECT TABLE_NAME, TABLE_TYPE FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() ORDER BY TABLE_NAME":"SHOW TABLES");}function
count_tables($h){$K=array();foreach($h
as$i)$K[$i]=count(get_vals("SHOW TABLES IN ".idf_escape($i)));return$K;}function
table_status($E="",$mc=false){$K=array();foreach(get_rows($mc&&min_version(5)?"SELECT TABLE_NAME AS Name, ENGINE AS Engine, TABLE_COMMENT AS Comment FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() ".($E!=""?"AND TABLE_NAME = ".q($E):"ORDER BY Name"):"SHOW TABLE STATUS".($E!=""?" LIKE ".q(addcslashes($E,"%_\\")):""))as$L){if($L["Engine"]=="InnoDB")$L["Comment"]=preg_replace('~(?:(.+); )?InnoDB free: .*~','\1',$L["Comment"]);if(!isset($L["Engine"]))$L["Comment"]="";if($E!="")return$L;$K[$L["Name"]]=$L;}return$K;}function
is_view($R){return$R["Engine"]===null;}function
fk_support($R){return
preg_match('~InnoDB|IBMDB2I~i',$R["Engine"])||(preg_match('~NDB~i',$R["Engine"])&&min_version(5.6));}function
fields($Q){$K=array();foreach(get_rows("SHOW FULL COLUMNS FROM ".table($Q))as$L){preg_match('~^([^( ]+)(?:\((.+)\))?( unsigned)?( zerofill)?$~',$L["Type"],$C);$K[$L["Field"]]=array("field"=>$L["Field"],"full_type"=>$L["Type"],"type"=>$C[1],"length"=>$C[2],"unsigned"=>ltrim($C[3].$C[4]),"default"=>($L["Default"]!=""||preg_match("~char|set~",$C[1])?$L["Default"]:null),"null"=>($L["Null"]=="YES"),"auto_increment"=>($L["Extra"]=="auto_increment"),"on_update"=>(preg_match('~^on update (.+)~i',$L["Extra"],$C)?$C[1]:""),"collation"=>$L["Collation"],"privileges"=>array_flip(preg_split('~, *~',$L["Privileges"])),"comment"=>$L["Comment"],"primary"=>($L["Key"]=="PRI"),"generated"=>preg_match('~^(VIRTUAL|PERSISTENT|STORED)~',$L["Extra"]),);}return$K;}function
indexes($Q,$f=null){$K=array();foreach(get_rows("SHOW INDEX FROM ".table($Q),$f)as$L){$E=$L["Key_name"];$K[$E]["type"]=($E=="PRIMARY"?"PRIMARY":($L["Index_type"]=="FULLTEXT"?"FULLTEXT":($L["Non_unique"]?($L["Index_type"]=="SPATIAL"?"SPATIAL":"INDEX"):"UNIQUE")));$K[$E]["columns"][]=$L["Column_name"];$K[$E]["lengths"][]=($L["Index_type"]=="SPATIAL"?null:$L["Sub_part"]);$K[$E]["descs"][]=null;}return$K;}function
foreign_keys($Q){global$e,$je;static$Me='(?:`(?:[^`]|``)+`|"(?:[^"]|"")+")';$K=array();$jb=$e->result("SHOW CREATE TABLE ".table($Q),1);if($jb){preg_match_all("~CONSTRAINT ($Me) FOREIGN KEY ?\\(((?:$Me,? ?)+)\\) REFERENCES ($Me)(?:\\.($Me))? \\(((?:$Me,? ?)+)\\)(?: ON DELETE ($je))?(?: ON UPDATE ($je))?~",$jb,$Bd,PREG_SET_ORDER);foreach($Bd
as$C){preg_match_all("~$Me~",$C[2],$Sf);preg_match_all("~$Me~",$C[5],$sg);$K[idf_unescape($C[1])]=array("db"=>idf_unescape($C[4]!=""?$C[3]:$C[4]),"table"=>idf_unescape($C[4]!=""?$C[4]:$C[3]),"source"=>array_map('idf_unescape',$Sf[0]),"target"=>array_map('idf_unescape',$sg[0]),"on_delete"=>($C[6]?$C[6]:"RESTRICT"),"on_update"=>($C[7]?$C[7]:"RESTRICT"),);}}return$K;}function
view($E){global$e;return
array("select"=>preg_replace('~^(?:[^`]|`[^`]*`)*\s+AS\s+~isU','',$e->result("SHOW CREATE VIEW ".table($E),1)));}function
collations(){$K=array();foreach(get_rows("SHOW COLLATION")as$L){if($L["Default"])$K[$L["Charset"]][-1]=$L["Collation"];else$K[$L["Charset"]][]=$L["Collation"];}ksort($K);foreach($K
as$z=>$X)asort($K[$z]);return$K;}function
information_schema($i){return(min_version(5)&&$i=="information_schema")||(min_version(5.5)&&$i=="performance_schema");}function
error(){global$e;return
h(preg_replace('~^You have an error.*syntax to use~U',"Syntax error",$e->error));}function
create_database($i,$Wa){return
queries("CREATE DATABASE ".idf_escape($i).($Wa?" COLLATE ".q($Wa):""));}function
drop_databases($h){$K=apply_queries("DROP DATABASE",$h,'idf_escape');restart_session();set_session("dbs",null);return$K;}function
rename_database($E,$Wa){$K=false;if(create_database($E,$Wa)){$qf=array();foreach(tables_list()as$Q=>$U)$qf[]=table($Q)." TO ".idf_escape($E).".".table($Q);$K=(!$qf||queries("RENAME TABLE ".implode(", ",$qf)));if($K)queries("DROP DATABASE ".idf_escape(DB));restart_session();set_session("dbs",null);}return$K;}function
auto_increment(){$za=" PRIMARY KEY";if($_GET["create"]!=""&&$_POST["auto_increment_col"]){foreach(indexes($_GET["create"])as$v){if(in_array($_POST["fields"][$_POST["auto_increment_col"]]["orig"],$v["columns"],true)){$za="";break;}if($v["type"]=="PRIMARY")$za=" UNIQUE";}}return" AUTO_INCREMENT$za";}function
alter_table($Q,$E,$m,$vc,$bb,$Vb,$Wa,$ya,$Ie){$sa=array();foreach($m
as$l)$sa[]=($l[1]?($Q!=""?($l[0]!=""?"CHANGE ".idf_escape($l[0]):"ADD"):" ")." ".implode($l[1]).($Q!=""?$l[2]:""):"DROP ".idf_escape($l[0]));$sa=array_merge($sa,$vc);$Zf=($bb!==null?" COMMENT=".q($bb):"").($Vb?" ENGINE=".q($Vb):"").($Wa?" COLLATE ".q($Wa):"").($ya!=""?" AUTO_INCREMENT=$ya":"");if($Q=="")return
queries("CREATE TABLE ".table($E)." (\n".implode(",\n",$sa)."\n)$Zf$Ie");if($Q!=$E)$sa[]="RENAME TO ".table($E);if($Zf)$sa[]=ltrim($Zf);return($sa||$Ie?queries("ALTER TABLE ".table($Q)."\n".implode(",\n",$sa).$Ie):true);}function
alter_indexes($Q,$sa){foreach($sa
as$z=>$X)$sa[$z]=($X[2]=="DROP"?"\nDROP INDEX ".idf_escape($X[1]):"\nADD $X[0] ".($X[0]=="PRIMARY"?"KEY ":"").($X[1]!=""?idf_escape($X[1])." ":"")."(".implode(", ",$X[2]).")");return
queries("ALTER TABLE ".table($Q).implode(",",$sa));}function
truncate_tables($S){return
apply_queries("TRUNCATE TABLE",$S);}function
drop_views($nh){return
queries("DROP VIEW ".implode(", ",array_map('table',$nh)));}function
drop_tables($S){return
queries("DROP TABLE ".implode(", ",array_map('table',$S)));}function
move_tables($S,$nh,$sg){$qf=array();foreach(array_merge($S,$nh)as$Q)$qf[]=table($Q)." TO ".idf_escape($sg).".".table($Q);return
queries("RENAME TABLE ".implode(", ",$qf));}function
copy_tables($S,$nh,$sg){queries("SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO'");foreach($S
as$Q){$E=($sg==DB?table("copy_$Q"):idf_escape($sg).".".table($Q));if(($_POST["overwrite"]&&!queries("\nDROP TABLE IF EXISTS $E"))||!queries("CREATE TABLE $E LIKE ".table($Q))||!queries("INSERT INTO $E SELECT * FROM ".table($Q)))return
false;foreach(get_rows("SHOW TRIGGERS LIKE ".q(addcslashes($Q,"%_\\")))as$L){$Mg=$L["Trigger"];if(!queries("CREATE TRIGGER ".($sg==DB?idf_escape("copy_$Mg"):idf_escape($sg).".".idf_escape($Mg))." $L[Timing] $L[Event] ON $E FOR EACH ROW\n$L[Statement];"))return
false;}}foreach($nh
as$Q){$E=($sg==DB?table("copy_$Q"):idf_escape($sg).".".table($Q));$mh=view($Q);if(($_POST["overwrite"]&&!queries("DROP VIEW IF EXISTS $E"))||!queries("CREATE VIEW $E AS $mh[select]"))return
false;}return
true;}function
trigger($E){if($E=="")return
array();$M=get_rows("SHOW TRIGGERS WHERE `Trigger` = ".q($E));return
reset($M);}function
triggers($Q){$K=array();foreach(get_rows("SHOW TRIGGERS LIKE ".q(addcslashes($Q,"%_\\")))as$L)$K[$L["Trigger"]]=array($L["Timing"],$L["Event"]);return$K;}function
trigger_options(){return
array("Timing"=>array("BEFORE","AFTER"),"Event"=>array("INSERT","UPDATE","DELETE"),"Type"=>array("FOR EACH ROW"),);}function
routine($E,$U){global$e,$Xb,$Xc,$Rg;$qa=array("bool","boolean","integer","double precision","real","dec","numeric","fixed","national char","national varchar");$Tf="(?:\\s|/\\*[\s\S]*?\\*/|(?:#|-- )[^\n]*\n?|--\r?\n)";$Qg="((".implode("|",array_merge(array_keys($Rg),$qa)).")\\b(?:\\s*\\(((?:[^'\")]|$Xb)++)\\))?\\s*(zerofill\\s*)?(unsigned(?:\\s+zerofill)?)?)(?:\\s*(?:CHARSET|CHARACTER\\s+SET)\\s*['\"]?([^'\"\\s,]+)['\"]?)?";$Me="$Tf*(".($U=="FUNCTION"?"":$Xc).")?\\s*(?:`((?:[^`]|``)*)`\\s*|\\b(\\S+)\\s+)$Qg";$g=$e->result("SHOW CREATE $U ".idf_escape($E),2);preg_match("~\\(((?:$Me\\s*,?)*)\\)\\s*".($U=="FUNCTION"?"RETURNS\\s+$Qg\\s+":"")."(.*)~is",$g,$C);$m=array();preg_match_all("~$Me\\s*,?~is",$C[1],$Bd,PREG_SET_ORDER);foreach($Bd
as$De)$m[]=array("field"=>str_replace("``","`",$De[2]).$De[3],"type"=>strtolower($De[5]),"length"=>preg_replace_callback("~$Xb~s",'normalize_enum',$De[6]),"unsigned"=>strtolower(preg_replace('~\s+~',' ',trim("$De[8] $De[7]"))),"null"=>1,"full_type"=>$De[4],"inout"=>strtoupper($De[1]),"collation"=>strtolower($De[9]),);if($U!="FUNCTION")return
array("fields"=>$m,"definition"=>$C[11]);return
array("fields"=>$m,"returns"=>array("type"=>$C[12],"length"=>$C[13],"unsigned"=>$C[15],"collation"=>$C[16]),"definition"=>$C[17],"language"=>"SQL",);}function
routines(){return
get_rows("SELECT ROUTINE_NAME AS SPECIFIC_NAME, ROUTINE_NAME, ROUTINE_TYPE, DTD_IDENTIFIER FROM information_schema.ROUTINES WHERE ROUTINE_SCHEMA = ".q(DB));}function
routine_languages(){return
array();}function
routine_id($E,$L){return
idf_escape($E);}function
last_id(){global$e;return$e->result("SELECT LAST_INSERT_ID()");}function
explain($e,$I){return$e->query("EXPLAIN ".(min_version(5.1)?"PARTITIONS ":"").$I);}function
found_rows($R,$Z){return($Z||$R["Engine"]!="InnoDB"?null:$R["Rows"]);}function
types(){return
array();}function
schemas(){return
array();}function
get_schema(){return"";}function
set_schema($Bf,$f=null){return
true;}function
create_sql($Q,$ya,$eg){global$e;$K=$e->result("SHOW CREATE TABLE ".table($Q),1);if(!$ya)$K=preg_replace('~ AUTO_INCREMENT=\d+~','',$K);return$K;}function
truncate_sql($Q){return"TRUNCATE ".table($Q);}function
use_sql($sb){return"USE ".idf_escape($sb);}function
trigger_sql($Q){$K="";foreach(get_rows("SHOW TRIGGERS LIKE ".q(addcslashes($Q,"%_\\")),null,"-- ")as$L)$K.="\nCREATE TRIGGER ".idf_escape($L["Trigger"])." $L[Timing] $L[Event] ON ".table($L["Table"])." FOR EACH ROW\n$L[Statement];;\n";return$K;}function
show_variables(){return
get_key_vals("SHOW VARIABLES");}function
process_list(){return
get_rows("SHOW FULL PROCESSLIST");}function
show_status(){return
get_key_vals("SHOW STATUS");}function
convert_field($l){if(preg_match("~binary~",$l["type"]))return"HEX(".idf_escape($l["field"]).")";if($l["type"]=="bit")return"BIN(".idf_escape($l["field"])." + 0)";if(preg_match("~geometry|point|linestring|polygon~",$l["type"]))return(min_version(8)?"ST_":"")."AsWKT(".idf_escape($l["field"]).")";}function
unconvert_field($l,$K){if(preg_match("~binary~",$l["type"]))$K="UNHEX($K)";if($l["type"]=="bit")$K="CONV($K, 2, 10) + 0";if(preg_match("~geometry|point|linestring|polygon~",$l["type"]))$K=(min_version(8)?"ST_":"")."GeomFromText($K, SRID($l[field]))";return$K;}function
support($nc){return!preg_match("~scheme|sequence|type|view_trigger|materializedview".(min_version(8)?"":"|descidx".(min_version(5.1)?"":"|event|partitioning".(min_version(5)?"":"|routine|trigger|view")))."~",$nc);}function
kill_process($X){return
queries("KILL ".number($X));}function
connection_id(){return"SELECT CONNECTION_ID()";}function
max_connections(){global$e;return$e->result("SELECT @@max_connections");}$y="sql";$Rg=array();$dg=array();foreach(array('Numbers'=>array("tinyint"=>3,"smallint"=>5,"mediumint"=>8,"int"=>10,"bigint"=>20,"decimal"=>66,"float"=>12,"double"=>21),'Date and time'=>array("date"=>10,"datetime"=>19,"timestamp"=>19,"time"=>10,"year"=>4),'Strings'=>array("char"=>255,"varchar"=>65535,"tinytext"=>255,"text"=>65535,"mediumtext"=>16777215,"longtext"=>4294967295),'Lists'=>array("enum"=>65535,"set"=>64),'Binary'=>array("bit"=>20,"binary"=>255,"varbinary"=>65535,"tinyblob"=>255,"blob"=>65535,"mediumblob"=>16777215,"longblob"=>4294967295),'Geometry'=>array("geometry"=>0,"point"=>0,"linestring"=>0,"polygon"=>0,"multipoint"=>0,"multilinestring"=>0,"multipolygon"=>0,"geometrycollection"=>0),)as$z=>$X){$Rg+=$X;$dg[$z]=array_keys($X);}$Yg=array("unsigned","zerofill","unsigned zerofill");$ne=array("=","<",">","<=",">=","!=","LIKE","LIKE %%","REGEXP","IN","FIND_IN_SET","IS NULL","NOT LIKE","NOT REGEXP","NOT IN","IS NOT NULL","SQL");$Ac=array("char_length","date","from_unixtime","lower","round","floor","ceil","sec_to_time","time_to_sec","upper");$Ec=array("avg","count","count distinct","group_concat","max","min","sum");$Nb=array(array("char"=>"md5/sha1/password/encrypt/uuid","binary"=>"md5/sha1","date|time"=>"now",),array(number_type()=>"+/-","date"=>"+ interval/- interval","time"=>"addtime/subtime","char|text"=>"concat",));}define("SERVER",$_GET[DRIVER]);define("DB",$_GET["db"]);define("ME",str_replace(":","%3a",preg_replace('~^[^?]*/([^?]*).*~','\1',$_SERVER["REQUEST_URI"])).'?'.(sid()?SID.'&':'').(SERVER!==null?DRIVER."=".urlencode(SERVER).'&':'').(isset($_GET["username"])?"username=".urlencode($_GET["username"]).'&':'').(DB!=""?'db='.urlencode(DB).'&'.(isset($_GET["ns"])?"ns=".urlencode($_GET["ns"])."&":""):''));$ga="4.7.5";class
Adminer{var$operators;function
name(){return"<a href='https://www.adminer.org/'".target_blank()." id='h1'>Adminer</a>";}function
credentials(){return
array(SERVER,$_GET["username"],get_password());}function
connectSsl(){}function
permanentLogin($g=false){return
password_file($g);}function
bruteForceKey(){return$_SERVER["REMOTE_ADDR"];}function
serverName($O){return
h($O);}function
database(){return
DB;}function
databases($tc=true){return
get_databases($tc);}function
schemas(){return
schemas();}function
queryTimeout(){return
2;}function
headers(){}function
csp(){return
csp();}function
head(){return
true;}function
css(){$K=array();$qc="adminer.css";if(file_exists($qc))$K[]="$qc?v=".crc32(file_get_contents($qc));return$K;}function
loginForm(){global$Gb;echo"<table cellspacing='0' class='layout'>\n",$this->loginFormField('driver','<tr><th>'.'System'.'<td>',html_select("auth[driver]",$Gb,DRIVER,"loginDriver(this);")."\n"),$this->loginFormField('server','<tr><th>'.'Server'.'<td>','<input name="auth[server]" value="'.h(SERVER).'" title="hostname[:port]" placeholder="localhost" autocapitalize="off">'."\n"),$this->loginFormField('username','<tr><th>'.'Username'.'<td>','<input name="auth[username]" id="username" value="'.h($_GET["username"]).'" autocomplete="username" autocapitalize="off">'.script("focus(qs('#username')); qs('#username').form['auth[driver]'].onchange();")),$this->loginFormField('password','<tr><th>'.'Password'.'<td>','<input type="password" name="auth[password]" autocomplete="current-password">'."\n"),$this->loginFormField('db','<tr><th>'.'Database'.'<td>','<input name="auth[db]" value="'.h($_GET["db"]).'" autocapitalize="off">'."\n"),"</table>\n","<p><input type='submit' value='".'Login'."'>\n",checkbox("auth[permanent]",1,$_COOKIE["adminer_permanent"],'Permanent login')."\n";}function
loginFormField($E,$Lc,$Y){return$Lc.$Y;}function
login($yd,$G){if($G=="")return
sprintf('Adminer does not support accessing a database without a password, <a href="https://www.adminer.org/en/password/"%s>more information</a>.',target_blank());return
true;}function
tableName($kg){return
h($kg["Name"]);}function
fieldName($l,$re=0){return'<span title="'.h($l["full_type"]).'">'.h($l["field"]).'</span>';}function
selectLinks($kg,$P=""){global$y,$j;echo'<p class="links">';$xd=array("select"=>'Select data');if(support("table")||support("indexes"))$xd["table"]='Show structure';if(support("table")){if(is_view($kg))$xd["view"]='Alter view';else$xd["create"]='Alter table';}if($P!==null)$xd["edit"]='New item';$E=$kg["Name"];foreach($xd
as$z=>$X)echo" <a href='".h(ME)."$z=".urlencode($E).($z=="edit"?$P:"")."'".bold(isset($_GET[$z])).">$X</a>";echo
doc_link(array($y=>$j->tableHelp($E)),"?"),"\n";}function
foreignKeys($Q){return
foreign_keys($Q);}function
backwardKeys($Q,$jg){return
array();}function
backwardKeysPrint($Aa,$L){}function
selectQuery($I,$Yf,$lc=false){global$y,$j;$K="</p>\n";if(!$lc&&($qh=$j->warnings())){$u="warnings";$K=", <a href='#$u'>".'Warnings'."</a>".script("qsl('a').onclick = partial(toggle, '$u');","")."$K<div id='$u' class='hidden'>\n$qh</div>\n";}return"<p><code class='jush-$y'>".h(str_replace("\n"," ",$I))."</code> <span class='time'>(".format_time($Yf).")</span>".(support("sql")?" <a href='".h(ME)."sql=".urlencode($I)."'>".'Edit'."</a>":"").$K;}function
sqlCommandQuery($I){return
shorten_utf8(trim($I),1000);}function
rowDescription($Q){return"";}function
rowDescriptions($M,$wc){return$M;}function
selectLink($X,$l){}function
selectVal($X,$A,$l,$ze){$K=($X===null?"<i>NULL</i>":(preg_match("~char|binary|boolean~",$l["type"])&&!preg_match("~var~",$l["type"])?"<code>$X</code>":$X));if(preg_match('~blob|bytea|raw|file~',$l["type"])&&!is_utf8($X))$K="<i>".lang(array('%d byte','%d bytes'),strlen($ze))."</i>";if(preg_match('~json~',$l["type"]))$K="<code class='jush-js'>$K</code>";return($A?"<a href='".h($A)."'".(is_url($A)?target_blank():"").">$K</a>":$K);}function
editVal($X,$l){return$X;}function
tableStructurePrint($m){echo"<div class='scrollable'>\n","<table cellspacing='0' class='nowrap'>\n","<thead><tr><th>".'Column'."<td>".'Type'.(support("comment")?"<td>".'Comment':"")."</thead>\n";foreach($m
as$l){echo"<tr".odd()."><th>".h($l["field"]),"<td><span title='".h($l["collation"])."'>".h($l["full_type"])."</span>",($l["null"]?" <i>NULL</i>":""),($l["auto_increment"]?" <i>".'Auto Increment'."</i>":""),(isset($l["default"])?" <span title='".'Default value'."'>[<b>".h($l["default"])."</b>]</span>":""),(support("comment")?"<td>".h($l["comment"]):""),"\n";}echo"</table>\n","</div>\n";}function
tableIndexesPrint($w){echo"<table cellspacing='0'>\n";foreach($w
as$E=>$v){ksort($v["columns"]);$Xe=array();foreach($v["columns"]as$z=>$X)$Xe[]="<i>".h($X)."</i>".($v["lengths"][$z]?"(".$v["lengths"][$z].")":"").($v["descs"][$z]?" DESC":"");echo"<tr title='".h($E)."'><th>$v[type]<td>".implode(", ",$Xe)."\n";}echo"</table>\n";}function
selectColumnsPrint($N,$d){global$Ac,$Ec;print_fieldset("select",'Select',$N);$t=0;$N[""]=array();foreach($N
as$z=>$X){$X=$_GET["columns"][$z];$c=select_input(" name='columns[$t][col]'",$d,$X["col"],($z!==""?"selectFieldChange":"selectAddRow"));echo"<div>".($Ac||$Ec?"<select name='columns[$t][fun]'>".optionlist(array(-1=>"")+array_filter(array('Functions'=>$Ac,'Aggregation'=>$Ec)),$X["fun"])."</select>".on_help("getTarget(event).value && getTarget(event).value.replace(/ |\$/, '(') + ')'",1).script("qsl('select').onchange = function () { helpClose();".($z!==""?"":" qsl('select, input', this.parentNode).onchange();")." };","")."($c)":$c)."</div>\n";$t++;}echo"</div></fieldset>\n";}function
selectSearchPrint($Z,$d,$w){print_fieldset("search",'Search',$Z);foreach($w
as$t=>$v){if($v["type"]=="FULLTEXT"){echo"<div>(<i>".implode("</i>, <i>",array_map('h',$v["columns"]))."</i>) AGAINST"," <input type='search' name='fulltext[$t]' value='".h($_GET["fulltext"][$t])."'>",script("qsl('input').oninput = selectFieldChange;",""),checkbox("boolean[$t]",1,isset($_GET["boolean"][$t]),"BOOL"),"</div>\n";}}$Ka="this.parentNode.firstChild.onchange();";foreach(array_merge((array)$_GET["where"],array(array()))as$t=>$X){if(!$X||("$X[col]$X[val]"!=""&&in_array($X["op"],$this->operators))){echo"<div>".select_input(" name='where[$t][col]'",$d,$X["col"],($X?"selectFieldChange":"selectAddRow"),"(".'anywhere'.")"),html_select("where[$t][op]",$this->operators,$X["op"],$Ka),"<input type='search' name='where[$t][val]' value='".h($X["val"])."'>",script("mixin(qsl('input'), {oninput: function () { $Ka }, onkeydown: selectSearchKeydown, onsearch: selectSearchSearch});",""),"</div>\n";}}echo"</div></fieldset>\n";}function
selectOrderPrint($re,$d,$w){print_fieldset("sort",'Sort',$re);$t=0;foreach((array)$_GET["order"]as$z=>$X){if($X!=""){echo"<div>".select_input(" name='order[$t]'",$d,$X,"selectFieldChange"),checkbox("desc[$t]",1,isset($_GET["desc"][$z]),'descending')."</div>\n";$t++;}}echo"<div>".select_input(" name='order[$t]'",$d,"","selectAddRow"),checkbox("desc[$t]",1,false,'descending')."</div>\n","</div></fieldset>\n";}function
selectLimitPrint($_){echo"<fieldset><legend>".'Limit'."</legend><div>";echo"<input type='number' name='limit' class='size' value='".h($_)."'>",script("qsl('input').oninput = selectFieldChange;",""),"</div></fieldset>\n";}function
selectLengthPrint($xg){if($xg!==null){echo"<fieldset><legend>".'Text length'."</legend><div>","<input type='number' name='text_length' class='size' value='".h($xg)."'>","</div></fieldset>\n";}}function
selectActionPrint($w){echo"<fieldset><legend>".'Action'."</legend><div>","<input type='submit' value='".'Select'."'>"," <span id='noindex' title='".'Full table scan'."'></span>","<script".nonce().">\n","var indexColumns = ";$d=array();foreach($w
as$v){$pb=reset($v["columns"]);if($v["type"]!="FULLTEXT"&&$pb)$d[$pb]=1;}$d[""]=1;foreach($d
as$z=>$X)json_row($z);echo";\n","selectFieldChange.call(qs('#form')['select']);\n","</script>\n","</div></fieldset>\n";}function
selectCommandPrint(){return!information_schema(DB);}function
selectImportPrint(){return!information_schema(DB);}function
selectEmailPrint($Sb,$d){}function
selectColumnsProcess($d,$w){global$Ac,$Ec;$N=array();$s=array();foreach((array)$_GET["columns"]as$z=>$X){if($X["fun"]=="count"||($X["col"]!=""&&(!$X["fun"]||in_array($X["fun"],$Ac)||in_array($X["fun"],$Ec)))){$N[$z]=apply_sql_function($X["fun"],($X["col"]!=""?idf_escape($X["col"]):"*"));if(!in_array($X["fun"],$Ec))$s[]=$N[$z];}}return
array($N,$s);}function
selectSearchProcess($m,$w){global$e,$j;$K=array();foreach($w
as$t=>$v){if($v["type"]=="FULLTEXT"&&$_GET["fulltext"][$t]!="")$K[]="MATCH (".implode(", ",array_map('idf_escape',$v["columns"])).") AGAINST (".q($_GET["fulltext"][$t]).(isset($_GET["boolean"][$t])?" IN BOOLEAN MODE":"").")";}foreach((array)$_GET["where"]as$z=>$X){if("$X[col]$X[val]"!=""&&in_array($X["op"],$this->operators)){$Ue="";$cb=" $X[op]";if(preg_match('~IN$~',$X["op"])){$Uc=process_length($X["val"]);$cb.=" ".($Uc!=""?$Uc:"(NULL)");}elseif($X["op"]=="SQL")$cb=" $X[val]";elseif($X["op"]=="LIKE %%")$cb=" LIKE ".$this->processInput($m[$X["col"]],"%$X[val]%");elseif($X["op"]=="ILIKE %%")$cb=" ILIKE ".$this->processInput($m[$X["col"]],"%$X[val]%");elseif($X["op"]=="FIND_IN_SET"){$Ue="$X[op](".q($X["val"]).", ";$cb=")";}elseif(!preg_match('~NULL$~',$X["op"]))$cb.=" ".$this->processInput($m[$X["col"]],$X["val"]);if($X["col"]!="")$K[]=$Ue.$j->convertSearch(idf_escape($X["col"]),$X,$m[$X["col"]]).$cb;else{$Ya=array();foreach($m
as$E=>$l){if((preg_match('~^[-\d.'.(preg_match('~IN$~',$X["op"])?',':'').']+$~',$X["val"])||!preg_match('~'.number_type().'|bit~',$l["type"]))&&(!preg_match("~[\x80-\xFF]~",$X["val"])||preg_match('~char|text|enum|set~',$l["type"])))$Ya[]=$Ue.$j->convertSearch(idf_escape($E),$X,$l).$cb;}$K[]=($Ya?"(".implode(" OR ",$Ya).")":"1 = 0");}}}return$K;}function
selectOrderProcess($m,$w){$K=array();foreach((array)$_GET["order"]as$z=>$X){if($X!="")$K[]=(preg_match('~^((COUNT\(DISTINCT |[A-Z0-9_]+\()(`(?:[^`]|``)+`|"(?:[^"]|"")+")\)|COUNT\(\*\))$~',$X)?$X:idf_escape($X)).(isset($_GET["desc"][$z])?" DESC":"");}return$K;}function
selectLimitProcess(){return(isset($_GET["limit"])?$_GET["limit"]:"50");}function
selectLengthProcess(){return(isset($_GET["text_length"])?$_GET["text_length"]:"100");}function
selectEmailProcess($Z,$wc){return
false;}function
selectQueryBuild($N,$Z,$s,$re,$_,$F){return"";}function
messageQuery($I,$yg,$lc=false){global$y,$j;restart_session();$Mc=&get_session("queries");if(!$Mc[$_GET["db"]])$Mc[$_GET["db"]]=array();if(strlen($I)>1e6)$I=preg_replace('~[\x80-\xFF]+$~','',substr($I,0,1e6))."\n…";$Mc[$_GET["db"]][]=array($I,time(),$yg);$Wf="sql-".count($Mc[$_GET["db"]]);$K="<a href='#$Wf' class='toggle'>".'SQL command'."</a>\n";if(!$lc&&($qh=$j->warnings())){$u="warnings-".count($Mc[$_GET["db"]]);$K="<a href='#$u' class='toggle'>".'Warnings'."</a>, $K<div id='$u' class='hidden'>\n$qh</div>\n";}return" <span class='time'>".@date("H:i:s")."</span>"." $K<div id='$Wf' class='hidden'><pre><code class='jush-$y'>".shorten_utf8($I,1000)."</code></pre>".($yg?" <span class='time'>($yg)</span>":'').(support("sql")?'<p><a href="'.h(str_replace("db=".urlencode(DB),"db=".urlencode($_GET["db"]),ME).'sql=&history='.(count($Mc[$_GET["db"]])-1)).'">'.'Edit'.'</a>':'').'</div>';}function
editFunctions($l){global$Nb;$K=($l["null"]?"NULL/":"");foreach($Nb
as$z=>$Ac){if(!$z||(!isset($_GET["call"])&&(isset($_GET["select"])||where($_GET)))){foreach($Ac
as$Me=>$X){if(!$Me||preg_match("~$Me~",$l["type"]))$K.="/$X";}if($z&&!preg_match('~set|blob|bytea|raw|file~',$l["type"]))$K.="/SQL";}}if($l["auto_increment"]&&!isset($_GET["select"])&&!where($_GET))$K='Auto Increment';return
explode("/",$K);}function
editInput($Q,$l,$wa,$Y){if($l["type"]=="enum")return(isset($_GET["select"])?"<label><input type='radio'$wa value='-1' checked><i>".'original'."</i></label> ":"").($l["null"]?"<label><input type='radio'$wa value=''".($Y!==null||isset($_GET["select"])?"":" checked")."><i>NULL</i></label> ":"").enum_input("radio",$wa,$l,$Y,0);return"";}function
editHint($Q,$l,$Y){return"";}function
processInput($l,$Y,$q=""){if($q=="SQL")return$Y;$E=$l["field"];$K=q($Y);if(preg_match('~^(now|getdate|uuid)$~',$q))$K="$q()";elseif(preg_match('~^current_(date|timestamp)$~',$q))$K=$q;elseif(preg_match('~^([+-]|\|\|)$~',$q))$K=idf_escape($E)." $q $K";elseif(preg_match('~^[+-] interval$~',$q))$K=idf_escape($E)." $q ".(preg_match("~^(\\d+|'[0-9.: -]') [A-Z_]+\$~i",$Y)?$Y:$K);elseif(preg_match('~^(addtime|subtime|concat)$~',$q))$K="$q(".idf_escape($E).", $K)";elseif(preg_match('~^(md5|sha1|password|encrypt)$~',$q))$K="$q($K)";return
unconvert_field($l,$K);}function
dumpOutput(){$K=array('text'=>'open','file'=>'save');if(function_exists('gzencode'))$K['gz']='gzip';return$K;}function
dumpFormat(){return
array('sql'=>'SQL','csv'=>'CSV,','csv;'=>'CSV;','tsv'=>'TSV');}function
dumpDatabase($i){}function
dumpTable($Q,$eg,$gd=0){if($_POST["format"]!="sql"){echo"\xef\xbb\xbf";if($eg)dump_csv(array_keys(fields($Q)));}else{if($gd==2){$m=array();foreach(fields($Q)as$E=>$l)$m[]=idf_escape($E)." $l[full_type]";$g="CREATE TABLE ".table($Q)." (".implode(", ",$m).")";}else$g=create_sql($Q,$_POST["auto_increment"],$eg);set_utf8mb4($g);if($eg&&$g){if($eg=="DROP+CREATE"||$gd==1)echo"DROP ".($gd==2?"VIEW":"TABLE")." IF EXISTS ".table($Q).";\n";if($gd==1)$g=remove_definer($g);echo"$g;\n\n";}}}function
dumpData($Q,$eg,$I){global$e,$y;$Dd=($y=="sqlite"?0:1048576);if($eg){if($_POST["format"]=="sql"){if($eg=="TRUNCATE+INSERT")echo
truncate_sql($Q).";\n";$m=fields($Q);}$J=$e->query($I,1);if($J){$Zc="";$Ia="";$id=array();$gg="";$oc=($Q!=''?'fetch_assoc':'fetch_row');while($L=$J->$oc()){if(!$id){$ih=array();foreach($L
as$X){$l=$J->fetch_field();$id[]=$l->name;$z=idf_escape($l->name);$ih[]="$z = VALUES($z)";}$gg=($eg=="INSERT+UPDATE"?"\nON DUPLICATE KEY UPDATE ".implode(", ",$ih):"").";\n";}if($_POST["format"]!="sql"){if($eg=="table"){dump_csv($id);$eg="INSERT";}dump_csv($L);}else{if(!$Zc)$Zc="INSERT INTO ".table($Q)." (".implode(", ",array_map('idf_escape',$id)).") VALUES";foreach($L
as$z=>$X){$l=$m[$z];$L[$z]=($X!==null?unconvert_field($l,preg_match(number_type(),$l["type"])&&!preg_match('~\[~',$l["full_type"])&&is_numeric($X)?$X:q(($X===false?0:$X))):"NULL");}$_f=($Dd?"\n":" ")."(".implode(",\t",$L).")";if(!$Ia)$Ia=$Zc.$_f;elseif(strlen($Ia)+4+strlen($_f)+strlen($gg)<$Dd)$Ia.=",$_f";else{echo$Ia.$gg;$Ia=$Zc.$_f;}}}if($Ia)echo$Ia.$gg;}elseif($_POST["format"]=="sql")echo"-- ".str_replace("\n"," ",$e->error)."\n";}}function
dumpFilename($Qc){return
friendly_url($Qc!=""?$Qc:(SERVER!=""?SERVER:"localhost"));}function
dumpHeaders($Qc,$Pd=false){$Ae=$_POST["output"];$ic=(preg_match('~sql~',$_POST["format"])?"sql":($Pd?"tar":"csv"));header("Content-Type: ".($Ae=="gz"?"application/x-gzip":($ic=="tar"?"application/x-tar":($ic=="sql"||$Ae!="file"?"text/plain":"text/csv")."; charset=utf-8")));if($Ae=="gz")ob_start('ob_gzencode',1e6);return$ic;}function
importServerPath(){return"adminer.sql";}function
homepage(){echo'<p class="links">'.($_GET["ns"]==""&&support("database")?'<a href="'.h(ME).'database=">'.'Alter database'."</a>\n":""),(support("scheme")?"<a href='".h(ME)."scheme='>".($_GET["ns"]!=""?'Alter schema':'Create schema')."</a>\n":""),($_GET["ns"]!==""?'<a href="'.h(ME).'schema=">'.'Database schema'."</a>\n":""),(support("privileges")?"<a href='".h(ME)."privileges='>".'Privileges'."</a>\n":"");return
true;}function
navigation($Od){global$ga,$y,$Gb,$e;echo'<h1>
',$this->name(),' <span class="version">',$ga,'</span>
<a href="https://www.adminer.org/#download"',target_blank(),' id="version">',(version_compare($ga,$_COOKIE["adminer_version"])<0?h($_COOKIE["adminer_version"]):""),'</a>
</h1>
';if($Od=="auth"){$Ae="";foreach((array)$_SESSION["pwds"]as$kh=>$Kf){foreach($Kf
as$O=>$gh){foreach($gh
as$V=>$G){if($G!==null){$vb=$_SESSION["db"][$kh][$O][$V];foreach(($vb?array_keys($vb):array(""))as$i)$Ae.="<li><a href='".h(auth_url($kh,$O,$V,$i))."'>($Gb[$kh]) ".h($V.($O!=""?"@".$this->serverName($O):"").($i!=""?" - $i":""))."</a>\n";}}}}if($Ae)echo"<ul id='logins'>\n$Ae</ul>\n".script("mixin(qs('#logins'), {onmouseover: menuOver, onmouseout: menuOut});");}else{if($_GET["ns"]!==""&&!$Od&&DB!=""){$e->select_db(DB);$S=table_status('',true);}echo
script_src(preg_replace("~\\?.*~","",ME)."?file=jush.js&version=4.7.5");if(support("sql")){echo'<script',nonce(),'>
';if($S){$xd=array();foreach($S
as$Q=>$U)$xd[]=preg_quote($Q,'/');echo"var jushLinks = { $y: [ '".js_escape(ME).(support("table")?"table=":"select=")."\$&', /\\b(".implode("|",$xd).")\\b/g ] };\n";foreach(array("bac","bra","sqlite_quo","mssql_bra")as$X)echo"jushLinks.$X = jushLinks.$y;\n";}$Jf=$e->server_info;echo'bodyLoad(\'',(is_object($e)?preg_replace('~^(\d\.?\d).*~s','\1',$Jf):""),'\'',(preg_match('~MariaDB~',$Jf)?", true":""),');
</script>
';}$this->databasesPrint($Od);if(DB==""||!$Od){echo"<p class='links'>".(support("sql")?"<a href='".h(ME)."sql='".bold(isset($_GET["sql"])&&!isset($_GET["import"])).">".'SQL command'."</a>\n<a href='".h(ME)."import='".bold(isset($_GET["import"])).">".'Import'."</a>\n":"")."";if(support("dump"))echo"<a href='".h(ME)."dump=".urlencode(isset($_GET["table"])?$_GET["table"]:$_GET["select"])."' id='dump'".bold(isset($_GET["dump"])).">".'Export'."</a>\n";}if($_GET["ns"]!==""&&!$Od&&DB!=""){echo'<a href="'.h(ME).'create="'.bold($_GET["create"]==="").">".'Create table'."</a>\n";if(!$S)echo"<p class='message'>".'No tables.'."\n";else$this->tablesPrint($S);}}}function
databasesPrint($Od){global$b,$e;$h=$this->databases();if($h&&!in_array(DB,$h))array_unshift($h,DB);echo'<form action="">
<p id="dbs">
';hidden_fields_get();$tb=script("mixin(qsl('select'), {onmousedown: dbMouseDown, onchange: dbChange});");echo"<span title='".'database'."'>".'DB'."</span>: ".($h?"<select name='db'>".optionlist(array(""=>"")+$h,DB)."</select>$tb":"<input name='db' value='".h(DB)."' autocapitalize='off'>\n"),"<input type='submit' value='".'Use'."'".($h?" class='hidden'":"").">\n";if($Od!="db"&&DB!=""&&$e->select_db(DB)){}foreach(array("import","sql","schema","dump","privileges")as$X){if(isset($_GET[$X])){echo"<input type='hidden' name='$X' value=''>";break;}}echo"</p></form>\n";}function
tablesPrint($S){echo"<ul id='tables'>".script("mixin(qs('#tables'), {onmouseover: menuOver, onmouseout: menuOut});");foreach($S
as$Q=>$Zf){$E=$this->tableName($Zf);if($E!=""){echo'<li><a href="'.h(ME).'select='.urlencode($Q).'"'.bold($_GET["select"]==$Q||$_GET["edit"]==$Q,"select").">".'select'."</a> ",(support("table")||support("indexes")?'<a href="'.h(ME).'table='.urlencode($Q).'"'.bold(in_array($Q,array($_GET["table"],$_GET["create"],$_GET["indexes"],$_GET["foreign"],$_GET["trigger"])),(is_view($Zf)?"view":"structure"))." title='".'Show structure'."'>$E</a>":"<span>$E</span>")."\n";}}echo"</ul>\n";}}$b=(function_exists('adminer_object')?adminer_object():new
Adminer);if($b->operators===null)$b->operators=$ne;function
page_header($Ag,$k="",$Ha=array(),$Bg=""){global$ca,$ga,$b,$Gb,$y;page_headers();if(is_ajax()&&$k){page_messages($k);exit;}$Cg=$Ag.($Bg!=""?": $Bg":"");$Dg=strip_tags($Cg.(SERVER!=""&&SERVER!="localhost"?h(" - ".SERVER):"")." - ".$b->name());echo'<!DOCTYPE html>
<html lang="en" dir="ltr">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="robots" content="noindex">
<title>',$Dg,'</title>
<link rel="stylesheet" type="text/css" href="',h(preg_replace("~\\?.*~","",ME)."?file=default.css&version=4.7.5"),'">
',script_src(preg_replace("~\\?.*~","",ME)."?file=functions.js&version=4.7.5");if($b->head()){echo'<link rel="shortcut icon" type="image/x-icon" href="',h(preg_replace("~\\?.*~","",ME)."?file=favicon.ico&version=4.7.5"),'">
<link rel="apple-touch-icon" href="',h(preg_replace("~\\?.*~","",ME)."?file=favicon.ico&version=4.7.5"),'">
';foreach($b->css()as$nb){echo'<link rel="stylesheet" type="text/css" href="',h($nb),'">
';}}echo'
<body class="ltr nojs">
';$qc=get_temp_dir()."/adminer.version";if(!$_COOKIE["adminer_version"]&&function_exists('openssl_verify')&&file_exists($qc)&&filemtime($qc)+86400>time()){$lh=unserialize(file_get_contents($qc));$df="-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAwqWOVuF5uw7/+Z70djoK
RlHIZFZPO0uYRezq90+7Amk+FDNd7KkL5eDve+vHRJBLAszF/7XKXe11xwliIsFs
DFWQlsABVZB3oisKCBEuI71J4kPH8dKGEWR9jDHFw3cWmoH3PmqImX6FISWbG3B8
h7FIx3jEaw5ckVPVTeo5JRm/1DZzJxjyDenXvBQ/6o9DgZKeNDgxwKzH+sw9/YCO
jHnq1cFpOIISzARlrHMa/43YfeNRAm/tsBXjSxembBPo7aQZLAWHmaj5+K19H10B
nCpz9Y++cipkVEiKRGih4ZEvjoFysEOdRLj6WiD/uUNky4xGeA6LaJqh5XpkFkcQ
fQIDAQAB
-----END PUBLIC KEY-----
";if(openssl_verify($lh["version"],base64_decode($lh["signature"]),$df)==1)$_COOKIE["adminer_version"]=$lh["version"];}echo'<script',nonce(),'>
mixin(document.body, {onkeydown: bodyKeydown, onclick: bodyClick',(isset($_COOKIE["adminer_version"])?"":", onload: partial(verifyVersion, '$ga', '".js_escape(ME)."', '".get_token()."')");?>});
document.body.className = document.body.className.replace(/ nojs/, ' js');
var offlineMessage = '<?php echo
js_escape('You are offline.'),'\';
var thousandsSeparator = \'',js_escape(','),'\';
</script>

<div id="help" class="jush-',$y,' jsonly hidden"></div>
',script("mixin(qs('#help'), {onmouseover: function () { helpOpen = 1; }, onmouseout: helpMouseout});"),'
<div id="content">
';if($Ha!==null){$A=substr(preg_replace('~\b(username|db|ns)=[^&]*&~','',ME),0,-1);echo'<p id="breadcrumb"><a href="'.h($A?$A:".").'">'.$Gb[DRIVER].'</a> &raquo; ';$A=substr(preg_replace('~\b(db|ns)=[^&]*&~','',ME),0,-1);$O=$b->serverName(SERVER);$O=($O!=""?$O:'Server');if($Ha===false)echo"$O\n";else{echo"<a href='".($A?h($A):".")."' accesskey='1' title='Alt+Shift+1'>$O</a> &raquo; ";if($_GET["ns"]!=""||(DB!=""&&is_array($Ha)))echo'<a href="'.h($A."&db=".urlencode(DB).(support("scheme")?"&ns=":"")).'">'.h(DB).'</a> &raquo; ';if(is_array($Ha)){if($_GET["ns"]!="")echo'<a href="'.h(substr(ME,0,-1)).'">'.h($_GET["ns"]).'</a> &raquo; ';foreach($Ha
as$z=>$X){$_b=(is_array($X)?$X[1]:h($X));if($_b!="")echo"<a href='".h(ME."$z=").urlencode(is_array($X)?$X[0]:$X)."'>$_b</a> &raquo; ";}}echo"$Ag\n";}}echo"<h2>$Cg</h2>\n","<div id='ajaxstatus' class='jsonly hidden'></div>\n";restart_session();page_messages($k);$h=&get_session("dbs");if(DB!=""&&$h&&!in_array(DB,$h,true))$h=null;stop_session();define("PAGE_HEADER",1);}function
page_headers(){global$b;header("Content-Type: text/html; charset=utf-8");header("Cache-Control: no-cache");header("X-Frame-Options: deny");header("X-XSS-Protection: 0");header("X-Content-Type-Options: nosniff");header("Referrer-Policy: origin-when-cross-origin");foreach($b->csp()as$mb){$Kc=array();foreach($mb
as$z=>$X)$Kc[]="$z $X";header("Content-Security-Policy: ".implode("; ",$Kc));}$b->headers();}function
csp(){return
array(array("script-src"=>"'self' 'unsafe-inline' 'nonce-".get_nonce()."' 'strict-dynamic'","connect-src"=>"'self'","frame-src"=>"https://www.adminer.org","object-src"=>"'none'","base-uri"=>"'none'","form-action"=>"'self'",),);}function
get_nonce(){static$Xd;if(!$Xd)$Xd=base64_encode(rand_string());return$Xd;}function
page_messages($k){$ah=preg_replace('~^[^?]*~','',$_SERVER["REQUEST_URI"]);$Md=$_SESSION["messages"][$ah];if($Md){echo"<div class='message'>".implode("</div>\n<div class='message'>",$Md)."</div>".script("messagesPrint();");unset($_SESSION["messages"][$ah]);}if($k)echo"<div class='error'>$k</div>\n";}function
page_footer($Od=""){global$b,$T;echo'</div>

';if($Od!="auth"){echo'<form action="" method="post">
<p class="logout">
<input type="submit" name="logout" value="Logout" id="logout">
<input type="hidden" name="token" value="',$T,'">
</p>
</form>
';}echo'<div id="menu">
';$b->navigation($Od);echo'</div>
',script("setupSubmitHighlight(document);");}function
int32($Rd){while($Rd>=2147483648)$Rd-=4294967296;while($Rd<=-2147483649)$Rd+=4294967296;return(int)$Rd;}function
long2str($W,$ph){$_f='';foreach($W
as$X)$_f.=pack('V',$X);if($ph)return
substr($_f,0,end($W));return$_f;}function
str2long($_f,$ph){$W=array_values(unpack('V*',str_pad($_f,4*ceil(strlen($_f)/4),"\0")));if($ph)$W[]=strlen($_f);return$W;}function
xxtea_mx($wh,$vh,$hg,$hd){return
int32((($wh>>5&0x7FFFFFF)^$vh<<2)+(($vh>>3&0x1FFFFFFF)^$wh<<4))^int32(($hg^$vh)+($hd^$wh));}function
encrypt_string($bg,$z){if($bg=="")return"";$z=array_values(unpack("V*",pack("H*",md5($z))));$W=str2long($bg,true);$Rd=count($W)-1;$wh=$W[$Rd];$vh=$W[0];$H=floor(6+52/($Rd+1));$hg=0;while($H-->0){$hg=int32($hg+0x9E3779B9);$Mb=$hg>>2&3;for($Be=0;$Be<$Rd;$Be++){$vh=$W[$Be+1];$Qd=xxtea_mx($wh,$vh,$hg,$z[$Be&3^$Mb]);$wh=int32($W[$Be]+$Qd);$W[$Be]=$wh;}$vh=$W[0];$Qd=xxtea_mx($wh,$vh,$hg,$z[$Be&3^$Mb]);$wh=int32($W[$Rd]+$Qd);$W[$Rd]=$wh;}return
long2str($W,false);}function
decrypt_string($bg,$z){if($bg=="")return"";if(!$z)return
false;$z=array_values(unpack("V*",pack("H*",md5($z))));$W=str2long($bg,false);$Rd=count($W)-1;$wh=$W[$Rd];$vh=$W[0];$H=floor(6+52/($Rd+1));$hg=int32($H*0x9E3779B9);while($hg){$Mb=$hg>>2&3;for($Be=$Rd;$Be>0;$Be--){$wh=$W[$Be-1];$Qd=xxtea_mx($wh,$vh,$hg,$z[$Be&3^$Mb]);$vh=int32($W[$Be]-$Qd);$W[$Be]=$vh;}$wh=$W[$Rd];$Qd=xxtea_mx($wh,$vh,$hg,$z[$Be&3^$Mb]);$vh=int32($W[0]-$Qd);$W[0]=$vh;$hg=int32($hg-0x9E3779B9);}return
long2str($W,true);}$e='';$Jc=$_SESSION["token"];if(!$Jc)$_SESSION["token"]=rand(1,1e6);$T=get_token();$Ne=array();if($_COOKIE["adminer_permanent"]){foreach(explode(" ",$_COOKIE["adminer_permanent"])as$X){list($z)=explode(":",$X);$Ne[$z]=$X;}}function
add_invalid_login(){global$b;$p=file_open_lock(get_temp_dir()."/adminer.invalid");if(!$p)return;$cd=unserialize(stream_get_contents($p));$yg=time();if($cd){foreach($cd
as$dd=>$X){if($X[0]<$yg)unset($cd[$dd]);}}$bd=&$cd[$b->bruteForceKey()];if(!$bd)$bd=array($yg+30*60,0);$bd[1]++;file_write_unlock($p,serialize($cd));}function
check_invalid_login(){global$b;$cd=unserialize(@file_get_contents(get_temp_dir()."/adminer.invalid"));$bd=$cd[$b->bruteForceKey()];$Wd=($bd[1]>29?$bd[0]-time():0);if($Wd>0)auth_error(lang(array('Too many unsuccessful logins, try again in %d minute.','Too many unsuccessful logins, try again in %d minutes.'),ceil($Wd/60)));}$xa=$_POST["auth"];if($xa){session_regenerate_id();$kh=$xa["driver"];$O=$xa["server"];$V=$xa["username"];$G=(string)$xa["password"];$i=$xa["db"];set_password($kh,$O,$V,$G);$_SESSION["db"][$kh][$O][$V][$i]=true;if($xa["permanent"]){$z=base64_encode($kh)."-".base64_encode($O)."-".base64_encode($V)."-".base64_encode($i);$Ye=$b->permanentLogin(true);$Ne[$z]="$z:".base64_encode($Ye?encrypt_string($G,$Ye):"");cookie("adminer_permanent",implode(" ",$Ne));}if(count($_POST)==1||DRIVER!=$kh||SERVER!=$O||$_GET["username"]!==$V||DB!=$i)redirect(auth_url($kh,$O,$V,$i));}elseif($_POST["logout"]){if($Jc&&!verify_token()){page_header('Logout','Invalid CSRF token. Send the form again.');page_footer("db");exit;}else{foreach(array("pwds","db","dbs","queries")as$z)set_session($z,null);unset_permanent();redirect(substr(preg_replace('~\b(username|db|ns)=[^&]*&~','',ME),0,-1),'Logout successful.'.' '.'Thanks for using Adminer, consider <a href="https://www.adminer.org/en/donation/">donating</a>.');}}elseif($Ne&&!$_SESSION["pwds"]){session_regenerate_id();$Ye=$b->permanentLogin();foreach($Ne
as$z=>$X){list(,$Qa)=explode(":",$X);list($kh,$O,$V,$i)=array_map('base64_decode',explode("-",$z));set_password($kh,$O,$V,decrypt_string(base64_decode($Qa),$Ye));$_SESSION["db"][$kh][$O][$V][$i]=true;}}function
unset_permanent(){global$Ne;foreach($Ne
as$z=>$X){list($kh,$O,$V,$i)=array_map('base64_decode',explode("-",$z));if($kh==DRIVER&&$O==SERVER&&$V==$_GET["username"]&&$i==DB)unset($Ne[$z]);}cookie("adminer_permanent",implode(" ",$Ne));}function
auth_error($k){global$b,$Jc;$Lf=session_name();if(isset($_GET["username"])){header("HTTP/1.1 403 Forbidden");if(($_COOKIE[$Lf]||$_GET[$Lf])&&!$Jc)$k='Session expired, please login again.';else{restart_session();add_invalid_login();$G=get_password();if($G!==null){if($G===false)$k.='<br>'.sprintf('Master password expired. <a href="https://www.adminer.org/en/extension/"%s>Implement</a> %s method to make it permanent.',target_blank(),'<code>permanentLogin()</code>');set_password(DRIVER,SERVER,$_GET["username"],null);}unset_permanent();}}if(!$_COOKIE[$Lf]&&$_GET[$Lf]&&ini_bool("session.use_only_cookies"))$k='Session support must be enabled.';$Ee=session_get_cookie_params();cookie("adminer_key",($_COOKIE["adminer_key"]?$_COOKIE["adminer_key"]:rand_string()),$Ee["lifetime"]);page_header('Login',$k,null);echo"<form action='' method='post'>\n","<div>";if(hidden_fields($_POST,array("auth")))echo"<p class='message'>".'The action will be performed after successful login with the same credentials.'."\n";echo"</div>\n";$b->loginForm();echo"</form>\n";page_footer("auth");exit;}if(isset($_GET["username"])&&!class_exists("Min_DB")){unset($_SESSION["pwds"][DRIVER]);unset_permanent();page_header('No extension',sprintf('None of the supported PHP extensions (%s) are available.',implode(", ",$Te)),false);page_footer("auth");exit;}stop_session(true);if(isset($_GET["username"])&&is_string(get_password())){list($Oc,$Pe)=explode(":",SERVER,2);if(is_numeric($Pe)&&$Pe<1024)auth_error('Connecting to privileged ports is not allowed.');check_invalid_login();$e=connect();$j=new
Min_Driver($e);}$yd=null;if(!is_object($e)||($yd=$b->login($_GET["username"],get_password()))!==true){$k=(is_string($e)?h($e):(is_string($yd)?$yd:'Invalid credentials.'));auth_error($k.(preg_match('~^ | $~',get_password())?'<br>'.'There is a space in the input password which might be the cause.':''));}if($xa&&$_POST["token"])$_POST["token"]=$T;$k='';if($_POST){if(!verify_token()){$Wc="max_input_vars";$Hd=ini_get($Wc);if(extension_loaded("suhosin")){foreach(array("suhosin.request.max_vars","suhosin.post.max_vars")as$z){$X=ini_get($z);if($X&&(!$Hd||$X<$Hd)){$Wc=$z;$Hd=$X;}}}$k=(!$_POST["token"]&&$Hd?sprintf('Maximum number of allowed fields exceeded. Please increase %s.',"'$Wc'"):'Invalid CSRF token. Send the form again.'.' '.'If you did not send this request from Adminer then close this page.');}}elseif($_SERVER["REQUEST_METHOD"]=="POST"){$k=sprintf('Too big POST data. Reduce the data or increase the %s configuration directive.',"'post_max_size'");if(isset($_GET["sql"]))$k.=' '.'You can upload a big SQL file via FTP and import it from server.';}function
select($J,$f=null,$ue=array(),$_=0){global$y;$xd=array();$w=array();$d=array();$Fa=array();$Rg=array();$K=array();odd('');for($t=0;(!$_||$t<$_)&&($L=$J->fetch_row());$t++){if(!$t){echo"<div class='scrollable'>\n","<table cellspacing='0' class='nowrap'>\n","<thead><tr>";for($x=0;$x<count($L);$x++){$l=$J->fetch_field();$E=$l->name;$te=$l->orgtable;$se=$l->orgname;$K[$l->table]=$te;if($ue&&$y=="sql")$xd[$x]=($E=="table"?"table=":($E=="possible_keys"?"indexes=":null));elseif($te!=""){if(!isset($w[$te])){$w[$te]=array();foreach(indexes($te,$f)as$v){if($v["type"]=="PRIMARY"){$w[$te]=array_flip($v["columns"]);break;}}$d[$te]=$w[$te];}if(isset($d[$te][$se])){unset($d[$te][$se]);$w[$te][$se]=$x;$xd[$x]=$te;}}if($l->charsetnr==63)$Fa[$x]=true;$Rg[$x]=$l->type;echo"<th".($te!=""||$l->name!=$se?" title='".h(($te!=""?"$te.":"").$se)."'":"").">".h($E).($ue?doc_link(array('sql'=>"explain-output.html#explain_".strtolower($E),'mariadb'=>"explain/#the-columns-in-explain-select",)):"");}echo"</thead>\n";}echo"<tr".odd().">";foreach($L
as$z=>$X){if($X===null)$X="<i>NULL</i>";elseif($Fa[$z]&&!is_utf8($X))$X="<i>".lang(array('%d byte','%d bytes'),strlen($X))."</i>";else{$X=h($X);if($Rg[$z]==254)$X="<code>$X</code>";}if(isset($xd[$z])&&!$d[$xd[$z]]){if($ue&&$y=="sql"){$Q=$L[array_search("table=",$xd)];$A=$xd[$z].urlencode($ue[$Q]!=""?$ue[$Q]:$Q);}else{$A="edit=".urlencode($xd[$z]);foreach($w[$xd[$z]]as$Ua=>$x)$A.="&where".urlencode("[".bracket_escape($Ua)."]")."=".urlencode($L[$x]);}$X="<a href='".h(ME.$A)."'>$X</a>";}echo"<td>$X";}}echo($t?"</table>\n</div>":"<p class='message'>".'No rows.')."\n";return$K;}function
referencable_primary($Gf){$K=array();foreach(table_status('',true)as$lg=>$Q){if($lg!=$Gf&&fk_support($Q)){foreach(fields($lg)as$l){if($l["primary"]){if($K[$lg]){unset($K[$lg]);break;}$K[$lg]=$l;}}}}return$K;}function
adminer_settings(){parse_str($_COOKIE["adminer_settings"],$Nf);return$Nf;}function
adminer_setting($z){$Nf=adminer_settings();return$Nf[$z];}function
set_adminer_settings($Nf){return
cookie("adminer_settings",http_build_query($Nf+adminer_settings()));}function
textarea($E,$Y,$M=10,$Ya=80){global$y;echo"<textarea name='$E' rows='$M' cols='$Ya' class='sqlarea jush-$y' spellcheck='false' wrap='off'>";if(is_array($Y)){foreach($Y
as$X)echo
h($X[0])."\n\n\n";}else
echo
h($Y);echo"</textarea>";}function
edit_type($z,$l,$Xa,$o=array(),$kc=array()){global$dg,$Rg,$Yg,$je;$U=$l["type"];echo'<td><select name="',h($z),'[type]" class="type" aria-labelledby="label-type">';if($U&&!isset($Rg[$U])&&!isset($o[$U])&&!in_array($U,$kc))$kc[]=$U;if($o)$dg['Foreign keys']=$o;echo
optionlist(array_merge($kc,$dg),$U),'</select>',on_help("getTarget(event).value",1),script("mixin(qsl('select'), {onfocus: function () { lastType = selectValue(this); }, onchange: editingTypeChange});",""),'<td><input name="',h($z),'[length]" value="',h($l["length"]),'" size="3"',(!$l["length"]&&preg_match('~var(char|binary)$~',$U)?" class='required'":"");echo' aria-labelledby="label-length">',script("mixin(qsl('input'), {onfocus: editingLengthFocus, oninput: editingLengthChange});",""),'<td class="options">',"<select name='".h($z)."[collation]'".(preg_match('~(char|text|enum|set)$~',$U)?"":" class='hidden'").'><option value="">('.'collation'.')'.optionlist($Xa,$l["collation"]).'</select>',($Yg?"<select name='".h($z)."[unsigned]'".(!$U||preg_match(number_type(),$U)?"":" class='hidden'").'><option>'.optionlist($Yg,$l["unsigned"]).'</select>':''),(isset($l['on_update'])?"<select name='".h($z)."[on_update]'".(preg_match('~timestamp|datetime~',$U)?"":" class='hidden'").'>'.optionlist(array(""=>"(".'ON UPDATE'.")","CURRENT_TIMESTAMP"),(preg_match('~^CURRENT_TIMESTAMP~i',$l["on_update"])?"CURRENT_TIMESTAMP":$l["on_update"])).'</select>':''),($o?"<select name='".h($z)."[on_delete]'".(preg_match("~`~",$U)?"":" class='hidden'")."><option value=''>(".'ON DELETE'.")".optionlist(explode("|",$je),$l["on_delete"])."</select> ":" ");}function
process_length($ud){global$Xb;return(preg_match("~^\\s*\\(?\\s*$Xb(?:\\s*,\\s*$Xb)*+\\s*\\)?\\s*\$~",$ud)&&preg_match_all("~$Xb~",$ud,$Bd)?"(".implode(",",$Bd[0]).")":preg_replace('~^[0-9].*~','(\0)',preg_replace('~[^-0-9,+()[\]]~','',$ud)));}function
process_type($l,$Va="COLLATE"){global$Yg;return" $l[type]".process_length($l["length"]).(preg_match(number_type(),$l["type"])&&in_array($l["unsigned"],$Yg)?" $l[unsigned]":"").(preg_match('~char|text|enum|set~',$l["type"])&&$l["collation"]?" $Va ".q($l["collation"]):"");}function
process_field($l,$Pg){return
array(idf_escape(trim($l["field"])),process_type($Pg),($l["null"]?" NULL":" NOT NULL"),default_value($l),(preg_match('~timestamp|datetime~',$l["type"])&&$l["on_update"]?" ON UPDATE $l[on_update]":""),(support("comment")&&$l["comment"]!=""?" COMMENT ".q($l["comment"]):""),($l["auto_increment"]?auto_increment():null),);}function
default_value($l){$xb=$l["default"];return($xb===null?"":" DEFAULT ".(preg_match('~char|binary|text|enum|set~',$l["type"])||preg_match('~^(?![a-z])~i',$xb)?q($xb):$xb));}function
type_class($U){foreach(array('char'=>'text','date'=>'time|year','binary'=>'blob','enum'=>'set',)as$z=>$X){if(preg_match("~$z|$X~",$U))return" class='$z'";}}function
edit_fields($m,$Xa,$U="TABLE",$o=array()){global$Xc;$m=array_values($m);echo'<thead><tr>
';if($U=="PROCEDURE"){echo'<td>';}echo'<th id="label-name">',($U=="TABLE"?'Column name':'Parameter name'),'<td id="label-type">Type<textarea id="enum-edit" rows="4" cols="12" wrap="off" style="display: none;"></textarea>',script("qs('#enum-edit').onblur = editingLengthBlur;"),'<td id="label-length">Length
<td>','Options';if($U=="TABLE"){echo'<td id="label-null">NULL
<td><input type="radio" name="auto_increment_col" value=""><acronym id="label-ai" title="Auto Increment">AI</acronym>',doc_link(array('sql'=>"example-auto-increment.html",'mariadb'=>"auto_increment/",)),'<td id="label-default">Default value
',(support("comment")?"<td id='label-comment'>".'Comment':"");}echo'<td>',"<input type='image' class='icon' name='add[".(support("move_col")?0:count($m))."]' src='".h(preg_replace("~\\?.*~","",ME)."?file=plus.gif&version=4.7.5")."' alt='+' title='".'Add next'."'>".script("row_count = ".count($m).";"),'</thead>
<tbody>
',script("mixin(qsl('tbody'), {onclick: editingClick, onkeydown: editingKeydown, oninput: editingInput});");foreach($m
as$t=>$l){$t++;$ve=$l[($_POST?"orig":"field")];$Db=(isset($_POST["add"][$t-1])||(isset($l["field"])&&!$_POST["drop_col"][$t]))&&(support("drop_col")||$ve=="");echo'<tr',($Db?"":" style='display: none;'"),'>
',($U=="PROCEDURE"?"<td>".html_select("fields[$t][inout]",explode("|",$Xc),$l["inout"]):""),'<th>';if($Db){echo'<input name="fields[',$t,'][field]" value="',h($l["field"]),'" data-maxlength="64" autocapitalize="off" aria-labelledby="label-name">',script("qsl('input').oninput = function () { editingNameChange.call(this);".($l["field"]!=""||count($m)>1?"":" editingAddRow.call(this);")." };","");}echo'<input type="hidden" name="fields[',$t,'][orig]" value="',h($ve),'">';edit_type("fields[$t]",$l,$Xa,$o);if($U=="TABLE"){echo'<td>',checkbox("fields[$t][null]",1,$l["null"],"","","block","label-null"),'<td><label class="block"><input type="radio" name="auto_increment_col" value="',$t,'"';if($l["auto_increment"]){echo' checked';}echo' aria-labelledby="label-ai"></label><td>',checkbox("fields[$t][has_default]",1,$l["has_default"],"","","","label-default"),'<input name="fields[',$t,'][default]" value="',h($l["default"]),'" aria-labelledby="label-default">',(support("comment")?"<td><input name='fields[$t][comment]' value='".h($l["comment"])."' data-maxlength='".(min_version(5.5)?1024:255)."' aria-labelledby='label-comment'>":"");}echo"<td>",(support("move_col")?"<input type='image' class='icon' name='add[$t]' src='".h(preg_replace("~\\?.*~","",ME)."?file=plus.gif&version=4.7.5")."' alt='+' title='".'Add next'."'> "."<input type='image' class='icon' name='up[$t]' src='".h(preg_replace("~\\?.*~","",ME)."?file=up.gif&version=4.7.5")."' alt='↑' title='".'Move up'."'> "."<input type='image' class='icon' name='down[$t]' src='".h(preg_replace("~\\?.*~","",ME)."?file=down.gif&version=4.7.5")."' alt='↓' title='".'Move down'."'> ":""),($ve==""||support("drop_col")?"<input type='image' class='icon' name='drop_col[$t]' src='".h(preg_replace("~\\?.*~","",ME)."?file=cross.gif&version=4.7.5")."' alt='x' title='".'Remove'."'>":"");}}function
process_fields(&$m){$ce=0;if($_POST["up"]){$od=0;foreach($m
as$z=>$l){if(key($_POST["up"])==$z){unset($m[$z]);array_splice($m,$od,0,array($l));break;}if(isset($l["field"]))$od=$ce;$ce++;}}elseif($_POST["down"]){$yc=false;foreach($m
as$z=>$l){if(isset($l["field"])&&$yc){unset($m[key($_POST["down"])]);array_splice($m,$ce,0,array($yc));break;}if(key($_POST["down"])==$z)$yc=$l;$ce++;}}elseif($_POST["add"]){$m=array_values($m);array_splice($m,key($_POST["add"]),0,array(array()));}elseif(!$_POST["drop_col"])return
false;return
true;}function
normalize_enum($C){return"'".str_replace("'","''",addcslashes(stripcslashes(str_replace($C[0][0].$C[0][0],$C[0][0],substr($C[0],1,-1))),'\\'))."'";}function
grant($r,$af,$d,$ie){if(!$af)return
true;if($af==array("ALL PRIVILEGES","GRANT OPTION"))return($r=="GRANT"?queries("$r ALL PRIVILEGES$ie WITH GRANT OPTION"):queries("$r ALL PRIVILEGES$ie")&&queries("$r GRANT OPTION$ie"));return
queries("$r ".preg_replace('~(GRANT OPTION)\([^)]*\)~','\1',implode("$d, ",$af).$d).$ie);}function
drop_create($Hb,$g,$Ib,$vg,$Jb,$B,$Ld,$Jd,$Kd,$fe,$Ud){if($_POST["drop"])query_redirect($Hb,$B,$Ld);elseif($fe=="")query_redirect($g,$B,$Kd);elseif($fe!=$Ud){$kb=queries($g);queries_redirect($B,$Jd,$kb&&queries($Hb));if($kb)queries($Ib);}else
queries_redirect($B,$Jd,queries($vg)&&queries($Jb)&&queries($Hb)&&queries($g));}function
create_trigger($ie,$L){global$y;$_g=" $L[Timing] $L[Event]".($L["Event"]=="UPDATE OF"?" ".idf_escape($L["Of"]):"");return"CREATE TRIGGER ".idf_escape($L["Trigger"]).($y=="mssql"?$ie.$_g:$_g.$ie).rtrim(" $L[Type]\n$L[Statement]",";").";";}function
create_routine($xf,$L){global$Xc,$y;$P=array();$m=(array)$L["fields"];ksort($m);foreach($m
as$l){if($l["field"]!="")$P[]=(preg_match("~^($Xc)\$~",$l["inout"])?"$l[inout] ":"").idf_escape($l["field"]).process_type($l,"CHARACTER SET");}$yb=rtrim("\n$L[definition]",";");return"CREATE $xf ".idf_escape(trim($L["name"]))." (".implode(", ",$P).")".(isset($_GET["function"])?" RETURNS".process_type($L["returns"],"CHARACTER SET"):"").($L["language"]?" LANGUAGE $L[language]":"").($y=="pgsql"?" AS ".q($yb):"$yb;");}function
remove_definer($I){return
preg_replace('~^([A-Z =]+) DEFINER=`'.preg_replace('~@(.*)~','`@`(%|\1)',logged_user()).'`~','\1',$I);}function
format_foreign_key($n){global$je;$i=$n["db"];$Yd=$n["ns"];return" FOREIGN KEY (".implode(", ",array_map('idf_escape',$n["source"])).") REFERENCES ".($i!=""&&$i!=$_GET["db"]?idf_escape($i).".":"").($Yd!=""&&$Yd!=$_GET["ns"]?idf_escape($Yd).".":"").table($n["table"])." (".implode(", ",array_map('idf_escape',$n["target"])).")".(preg_match("~^($je)\$~",$n["on_delete"])?" ON DELETE $n[on_delete]":"").(preg_match("~^($je)\$~",$n["on_update"])?" ON UPDATE $n[on_update]":"");}function
tar_file($qc,$Eg){$K=pack("a100a8a8a8a12a12",$qc,644,0,0,decoct($Eg->size),decoct(time()));$Pa=8*32;for($t=0;$t<strlen($K);$t++)$Pa+=ord($K[$t]);$K.=sprintf("%06o",$Pa)."\0 ";echo$K,str_repeat("\0",512-strlen($K));$Eg->send();echo
str_repeat("\0",511-($Eg->size+511)%512);}function
ini_bytes($Wc){$X=ini_get($Wc);switch(strtolower(substr($X,-1))){case'g':$X*=1024;case'm':$X*=1024;case'k':$X*=1024;}return$X;}function
doc_link($Le,$wg="<sup>?</sup>"){global$y,$e;$Jf=$e->server_info;$lh=preg_replace('~^(\d\.?\d).*~s','\1',$Jf);$ch=array('sql'=>"https://dev.mysql.com/doc/refman/$lh/en/",'sqlite'=>"https://www.sqlite.org/",'pgsql'=>"https://www.postgresql.org/docs/$lh/",'mssql'=>"https://msdn.microsoft.com/library/",'oracle'=>"https://www.oracle.com/pls/topic/lookup?ctx=db".preg_replace('~^.* (\d+)\.(\d+)\.\d+\.\d+\.\d+.*~s','\1\2',$Jf)."&id=",);if(preg_match('~MariaDB~',$Jf)){$ch['sql']="https://mariadb.com/kb/en/library/";$Le['sql']=(isset($Le['mariadb'])?$Le['mariadb']:str_replace(".html","/",$Le['sql']));}return($Le[$y]?"<a href='$ch[$y]$Le[$y]'".target_blank().">$wg</a>":"");}function
ob_gzencode($cg){return
gzencode($cg);}function
db_size($i){global$e;if(!$e->select_db($i))return"?";$K=0;foreach(table_status()as$R)$K+=$R["Data_length"]+$R["Index_length"];return
format_number($K);}function
set_utf8mb4($g){global$e;static$P=false;if(!$P&&preg_match('~\butf8mb4~i',$g)){$P=true;echo"SET NAMES ".charset($e).";\n\n";}}function
connect_error(){global$b,$e,$T,$k,$Gb;if(DB!=""){header("HTTP/1.1 404 Not Found");page_header('Database'.": ".h(DB),'Invalid database.',true);}else{if($_POST["db"]&&!$k)queries_redirect(substr(ME,0,-1),'Databases have been dropped.',drop_databases($_POST["db"]));page_header('Select database',$k,false);echo"<p class='links'>\n";foreach(array('database'=>'Create database','privileges'=>'Privileges','processlist'=>'Process list','variables'=>'Variables','status'=>'Status',)as$z=>$X){if(support($z))echo"<a href='".h(ME)."$z='>$X</a>\n";}echo"<p>".sprintf('%s version: %s through PHP extension %s',$Gb[DRIVER],"<b>".h($e->server_info)."</b>","<b>$e->extension</b>")."\n","<p>".sprintf('Logged as: %s',"<b>".h(logged_user())."</b>")."\n";$h=$b->databases();if($h){$Cf=support("scheme");$Xa=collations();echo"<form action='' method='post'>\n","<table cellspacing='0' class='checkable'>\n",script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});"),"<thead><tr>".(support("database")?"<td>":"")."<th>".'Database'." - <a href='".h(ME)."refresh=1'>".'Refresh'."</a>"."<td>".'Collation'."<td>".'Tables'."<td>".'Size'." - <a href='".h(ME)."dbsize=1'>".'Compute'."</a>".script("qsl('a').onclick = partial(ajaxSetHtml, '".js_escape(ME)."script=connect');","")."</thead>\n";$h=($_GET["dbsize"]?count_tables($h):array_flip($h));foreach($h
as$i=>$S){$wf=h(ME)."db=".urlencode($i);$u=h("Db-".$i);echo"<tr".odd().">".(support("database")?"<td>".checkbox("db[]",$i,in_array($i,(array)$_POST["db"]),"","","",$u):""),"<th><a href='$wf' id='$u'>".h($i)."</a>";$Wa=h(db_collation($i,$Xa));echo"<td>".(support("database")?"<a href='$wf".($Cf?"&amp;ns=":"")."&amp;database=' title='".'Alter database'."'>$Wa</a>":$Wa),"<td align='right'><a href='$wf&amp;schema=' id='tables-".h($i)."' title='".'Database schema'."'>".($_GET["dbsize"]?$S:"?")."</a>","<td align='right' id='size-".h($i)."'>".($_GET["dbsize"]?db_size($i):"?"),"\n";}echo"</table>\n",(support("database")?"<div class='footer'><div>\n"."<fieldset><legend>".'Selected'." <span id='selected'></span></legend><div>\n"."<input type='hidden' name='all' value=''>".script("qsl('input').onclick = function () { selectCount('selected', formChecked(this, /^db/)); };")."<input type='submit' name='drop' value='".'Drop'."'>".confirm()."\n"."</div></fieldset>\n"."</div></div>\n":""),"<input type='hidden' name='token' value='$T'>\n","</form>\n",script("tableCheck();");}}page_footer("db");}if(isset($_GET["status"]))$_GET["variables"]=$_GET["status"];if(isset($_GET["import"]))$_GET["sql"]=$_GET["import"];if(!(DB!=""?$e->select_db(DB):isset($_GET["sql"])||isset($_GET["dump"])||isset($_GET["database"])||isset($_GET["processlist"])||isset($_GET["privileges"])||isset($_GET["user"])||isset($_GET["variables"])||$_GET["script"]=="connect"||$_GET["script"]=="kill")){if(DB!=""||$_GET["refresh"]){restart_session();set_session("dbs",null);}connect_error();exit;}$je="RESTRICT|NO ACTION|CASCADE|SET NULL|SET DEFAULT";class
TmpFile{var$handler;var$size;function
__construct(){$this->handler=tmpfile();}function
write($fb){$this->size+=strlen($fb);fwrite($this->handler,$fb);}function
send(){fseek($this->handler,0);fpassthru($this->handler);fclose($this->handler);}}$Xb="'(?:''|[^'\\\\]|\\\\.)*'";$Xc="IN|OUT|INOUT";if(isset($_GET["select"])&&($_POST["edit"]||$_POST["clone"])&&!$_POST["save"])$_GET["edit"]=$_GET["select"];if(isset($_GET["callf"]))$_GET["call"]=$_GET["callf"];if(isset($_GET["function"]))$_GET["procedure"]=$_GET["function"];if(isset($_GET["download"])){$a=$_GET["download"];$m=fields($a);header("Content-Type: application/octet-stream");header("Content-Disposition: attachment; filename=".friendly_url("$a-".implode("_",$_GET["where"])).".".friendly_url($_GET["field"]));$N=array(idf_escape($_GET["field"]));$J=$j->select($a,$N,array(where($_GET,$m)),$N);$L=($J?$J->fetch_row():array());echo$j->value($L[0],$m[$_GET["field"]]);exit;}elseif(isset($_GET["table"])){$a=$_GET["table"];$m=fields($a);if(!$m)$k=error();$R=table_status1($a,true);$E=$b->tableName($R);page_header(($m&&is_view($R)?$R['Engine']=='materialized view'?'Materialized view':'View':'Table').": ".($E!=""?$E:h($a)),$k);$b->selectLinks($R);$bb=$R["Comment"];if($bb!="")echo"<p class='nowrap'>".'Comment'.": ".h($bb)."\n";if($m)$b->tableStructurePrint($m);if(!is_view($R)){if(support("indexes")){echo"<h3 id='indexes'>".'Indexes'."</h3>\n";$w=indexes($a);if($w)$b->tableIndexesPrint($w);echo'<p class="links"><a href="'.h(ME).'indexes='.urlencode($a).'">'.'Alter indexes'."</a>\n";}if(fk_support($R)){echo"<h3 id='foreign-keys'>".'Foreign keys'."</h3>\n";$o=foreign_keys($a);if($o){echo"<table cellspacing='0'>\n","<thead><tr><th>".'Source'."<td>".'Target'."<td>".'ON DELETE'."<td>".'ON UPDATE'."<td></thead>\n";foreach($o
as$E=>$n){echo"<tr title='".h($E)."'>","<th><i>".implode("</i>, <i>",array_map('h',$n["source"]))."</i>","<td><a href='".h($n["db"]!=""?preg_replace('~db=[^&]*~',"db=".urlencode($n["db"]),ME):($n["ns"]!=""?preg_replace('~ns=[^&]*~',"ns=".urlencode($n["ns"]),ME):ME))."table=".urlencode($n["table"])."'>".($n["db"]!=""?"<b>".h($n["db"])."</b>.":"").($n["ns"]!=""?"<b>".h($n["ns"])."</b>.":"").h($n["table"])."</a>","(<i>".implode("</i>, <i>",array_map('h',$n["target"]))."</i>)","<td>".h($n["on_delete"])."\n","<td>".h($n["on_update"])."\n",'<td><a href="'.h(ME.'foreign='.urlencode($a).'&name='.urlencode($E)).'">'.'Alter'.'</a>';}echo"</table>\n";}echo'<p class="links"><a href="'.h(ME).'foreign='.urlencode($a).'">'.'Add foreign key'."</a>\n";}}if(support(is_view($R)?"view_trigger":"trigger")){echo"<h3 id='triggers'>".'Triggers'."</h3>\n";$Og=triggers($a);if($Og){echo"<table cellspacing='0'>\n";foreach($Og
as$z=>$X)echo"<tr valign='top'><td>".h($X[0])."<td>".h($X[1])."<th>".h($z)."<td><a href='".h(ME.'trigger='.urlencode($a).'&name='.urlencode($z))."'>".'Alter'."</a>\n";echo"</table>\n";}echo'<p class="links"><a href="'.h(ME).'trigger='.urlencode($a).'">'.'Add trigger'."</a>\n";}}elseif(isset($_GET["schema"])){page_header('Database schema',"",array(),h(DB.($_GET["ns"]?".$_GET[ns]":"")));$mg=array();$ng=array();$ea=($_GET["schema"]?$_GET["schema"]:$_COOKIE["adminer_schema-".str_replace(".","_",DB)]);preg_match_all('~([^:]+):([-0-9.]+)x([-0-9.]+)(_|$)~',$ea,$Bd,PREG_SET_ORDER);foreach($Bd
as$t=>$C){$mg[$C[1]]=array($C[2],$C[3]);$ng[]="\n\t'".js_escape($C[1])."': [ $C[2], $C[3] ]";}$Gg=0;$Ca=-1;$Bf=array();$nf=array();$sd=array();foreach(table_status('',true)as$Q=>$R){if(is_view($R))continue;$Qe=0;$Bf[$Q]["fields"]=array();foreach(fields($Q)as$E=>$l){$Qe+=1.25;$l["pos"]=$Qe;$Bf[$Q]["fields"][$E]=$l;}$Bf[$Q]["pos"]=($mg[$Q]?$mg[$Q]:array($Gg,0));foreach($b->foreignKeys($Q)as$X){if(!$X["db"]){$qd=$Ca;if($mg[$Q][1]||$mg[$X["table"]][1])$qd=min(floatval($mg[$Q][1]),floatval($mg[$X["table"]][1]))-1;else$Ca-=.1;while($sd[(string)$qd])$qd-=.0001;$Bf[$Q]["references"][$X["table"]][(string)$qd]=array($X["source"],$X["target"]);$nf[$X["table"]][$Q][(string)$qd]=$X["target"];$sd[(string)$qd]=true;}}$Gg=max($Gg,$Bf[$Q]["pos"][0]+2.5+$Qe);}echo'<div id="schema" style="height: ',$Gg,'em;">
<script',nonce(),'>
qs(\'#schema\').onselectstart = function () { return false; };
var tablePos = {',implode(",",$ng)."\n",'};
var em = qs(\'#schema\').offsetHeight / ',$Gg,';
document.onmousemove = schemaMousemove;
document.onmouseup = partialArg(schemaMouseup, \'',js_escape(DB),'\');
</script>
';foreach($Bf
as$E=>$Q){echo"<div class='table' style='top: ".$Q["pos"][0]."em; left: ".$Q["pos"][1]."em;'>",'<a href="'.h(ME).'table='.urlencode($E).'"><b>'.h($E)."</b></a>",script("qsl('div').onmousedown = schemaMousedown;");foreach($Q["fields"]as$l){$X='<span'.type_class($l["type"]).' title="'.h($l["full_type"].($l["null"]?" NULL":'')).'">'.h($l["field"]).'</span>';echo"<br>".($l["primary"]?"<i>$X</i>":$X);}foreach((array)$Q["references"]as$tg=>$of){foreach($of
as$qd=>$kf){$rd=$qd-$mg[$E][1];$t=0;foreach($kf[0]as$Sf)echo"\n<div class='references' title='".h($tg)."' id='refs$qd-".($t++)."' style='left: $rd"."em; top: ".$Q["fields"][$Sf]["pos"]."em; padding-top: .5em;'><div style='border-top: 1px solid Gray; width: ".(-$rd)."em;'></div></div>";}}foreach((array)$nf[$E]as$tg=>$of){foreach($of
as$qd=>$d){$rd=$qd-$mg[$E][1];$t=0;foreach($d
as$sg)echo"\n<div class='references' title='".h($tg)."' id='refd$qd-".($t++)."' style='left: $rd"."em; top: ".$Q["fields"][$sg]["pos"]."em; height: 1.25em; background: url(".h(preg_replace("~\\?.*~","",ME)."?file=arrow.gif) no-repeat right center;&version=4.7.5")."'><div style='height: .5em; border-bottom: 1px solid Gray; width: ".(-$rd)."em;'></div></div>";}}echo"\n</div>\n";}foreach($Bf
as$E=>$Q){foreach((array)$Q["references"]as$tg=>$of){foreach($of
as$qd=>$kf){$Nd=$Gg;$Fd=-10;foreach($kf[0]as$z=>$Sf){$Re=$Q["pos"][0]+$Q["fields"][$Sf]["pos"];$Se=$Bf[$tg]["pos"][0]+$Bf[$tg]["fields"][$kf[1][$z]]["pos"];$Nd=min($Nd,$Re,$Se);$Fd=max($Fd,$Re,$Se);}echo"<div class='references' id='refl$qd' style='left: $qd"."em; top: $Nd"."em; padding: .5em 0;'><div style='border-right: 1px solid Gray; margin-top: 1px; height: ".($Fd-$Nd)."em;'></div></div>\n";}}}echo'</div>
<p class="links"><a href="',h(ME."schema=".urlencode($ea)),'" id="schema-link">Permanent link</a>
';}elseif(isset($_GET["dump"])){$a=$_GET["dump"];if($_POST&&!$k){$ib="";foreach(array("output","format","db_style","routines","events","table_style","auto_increment","triggers","data_style")as$z)$ib.="&$z=".urlencode($_POST[$z]);cookie("adminer_export",substr($ib,1));$S=array_flip((array)$_POST["tables"])+array_flip((array)$_POST["data"]);$ic=dump_headers((count($S)==1?key($S):DB),(DB==""||count($S)>1));$fd=preg_match('~sql~',$_POST["format"]);if($fd){echo"-- Adminer $ga ".$Gb[DRIVER]." dump\n\n";if($y=="sql"){echo"SET NAMES utf8;
SET time_zone = '+00:00';
".($_POST["data_style"]?"SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';
":"")."
";$e->query("SET time_zone = '+00:00';");}}$eg=$_POST["db_style"];$h=array(DB);if(DB==""){$h=$_POST["databases"];if(is_string($h))$h=explode("\n",rtrim(str_replace("\r","",$h),"\n"));}foreach((array)$h
as$i){$b->dumpDatabase($i);if($e->select_db($i)){if($fd&&preg_match('~CREATE~',$eg)&&($g=$e->result("SHOW CREATE DATABASE ".idf_escape($i),1))){set_utf8mb4($g);if($eg=="DROP+CREATE")echo"DROP DATABASE IF EXISTS ".idf_escape($i).";\n";echo"$g;\n";}if($fd){if($eg)echo
use_sql($i).";\n\n";$_e="";if($_POST["routines"]){foreach(array("FUNCTION","PROCEDURE")as$xf){foreach(get_rows("SHOW $xf STATUS WHERE Db = ".q($i),null,"-- ")as$L){$g=remove_definer($e->result("SHOW CREATE $xf ".idf_escape($L["Name"]),2));set_utf8mb4($g);$_e.=($eg!='DROP+CREATE'?"DROP $xf IF EXISTS ".idf_escape($L["Name"]).";;\n":"")."$g;;\n\n";}}}if($_POST["events"]){foreach(get_rows("SHOW EVENTS",null,"-- ")as$L){$g=remove_definer($e->result("SHOW CREATE EVENT ".idf_escape($L["Name"]),3));set_utf8mb4($g);$_e.=($eg!='DROP+CREATE'?"DROP EVENT IF EXISTS ".idf_escape($L["Name"]).";;\n":"")."$g;;\n\n";}}if($_e)echo"DELIMITER ;;\n\n$_e"."DELIMITER ;\n\n";}if($_POST["table_style"]||$_POST["data_style"]){$nh=array();foreach(table_status('',true)as$E=>$R){$Q=(DB==""||in_array($E,(array)$_POST["tables"]));$qb=(DB==""||in_array($E,(array)$_POST["data"]));if($Q||$qb){if($ic=="tar"){$Eg=new
TmpFile;ob_start(array($Eg,'write'),1e5);}$b->dumpTable($E,($Q?$_POST["table_style"]:""),(is_view($R)?2:0));if(is_view($R))$nh[]=$E;elseif($qb){$m=fields($E);$b->dumpData($E,$_POST["data_style"],"SELECT *".convert_fields($m,$m)." FROM ".table($E));}if($fd&&$_POST["triggers"]&&$Q&&($Og=trigger_sql($E)))echo"\nDELIMITER ;;\n$Og\nDELIMITER ;\n";if($ic=="tar"){ob_end_flush();tar_file((DB!=""?"":"$i/")."$E.csv",$Eg);}elseif($fd)echo"\n";}}foreach($nh
as$mh)$b->dumpTable($mh,$_POST["table_style"],1);if($ic=="tar")echo
pack("x512");}}}if($fd)echo"-- ".$e->result("SELECT NOW()")."\n";exit;}page_header('Export',$k,($_GET["export"]!=""?array("table"=>$_GET["export"]):array()),h(DB));echo'
<form action="" method="post">
<table cellspacing="0" class="layout">
';$ub=array('','USE','DROP+CREATE','CREATE');$og=array('','DROP+CREATE','CREATE');$rb=array('','TRUNCATE+INSERT','INSERT');if($y=="sql")$rb[]='INSERT+UPDATE';parse_str($_COOKIE["adminer_export"],$L);if(!$L)$L=array("output"=>"text","format"=>"sql","db_style"=>(DB!=""?"":"CREATE"),"table_style"=>"DROP+CREATE","data_style"=>"INSERT");if(!isset($L["events"])){$L["routines"]=$L["events"]=($_GET["dump"]=="");$L["triggers"]=$L["table_style"];}echo"<tr><th>".'Output'."<td>".html_select("output",$b->dumpOutput(),$L["output"],0)."\n";echo"<tr><th>".'Format'."<td>".html_select("format",$b->dumpFormat(),$L["format"],0)."\n";echo($y=="sqlite"?"":"<tr><th>".'Database'."<td>".html_select('db_style',$ub,$L["db_style"]).(support("routine")?checkbox("routines",1,$L["routines"],'Routines'):"").(support("event")?checkbox("events",1,$L["events"],'Events'):"")),"<tr><th>".'Tables'."<td>".html_select('table_style',$og,$L["table_style"]).checkbox("auto_increment",1,$L["auto_increment"],'Auto Increment').(support("trigger")?checkbox("triggers",1,$L["triggers"],'Triggers'):""),"<tr><th>".'Data'."<td>".html_select('data_style',$rb,$L["data_style"]),'</table>
<p><input type="submit" value="Export">
<input type="hidden" name="token" value="',$T,'">

<table cellspacing="0">
',script("qsl('table').onclick = dumpClick;");$Ve=array();if(DB!=""){$Na=($a!=""?"":" checked");echo"<thead><tr>","<th style='text-align: left;'><label class='block'><input type='checkbox' id='check-tables'$Na>".'Tables'."</label>".script("qs('#check-tables').onclick = partial(formCheck, /^tables\\[/);",""),"<th style='text-align: right;'><label class='block'>".'Data'."<input type='checkbox' id='check-data'$Na></label>".script("qs('#check-data').onclick = partial(formCheck, /^data\\[/);",""),"</thead>\n";$nh="";$pg=tables_list();foreach($pg
as$E=>$U){$Ue=preg_replace('~_.*~','',$E);$Na=($a==""||$a==(substr($a,-1)=="%"?"$Ue%":$E));$Xe="<tr><td>".checkbox("tables[]",$E,$Na,$E,"","block");if($U!==null&&!preg_match('~table~i',$U))$nh.="$Xe\n";else
echo"$Xe<td align='right'><label class='block'><span id='Rows-".h($E)."'></span>".checkbox("data[]",$E,$Na)."</label>\n";$Ve[$Ue]++;}echo$nh;if($pg)echo
script("ajaxSetHtml('".js_escape(ME)."script=db');");}else{echo"<thead><tr><th style='text-align: left;'>","<label class='block'><input type='checkbox' id='check-databases'".($a==""?" checked":"").">".'Database'."</label>",script("qs('#check-databases').onclick = partial(formCheck, /^databases\\[/);",""),"</thead>\n";$h=$b->databases();if($h){foreach($h
as$i){if(!information_schema($i)){$Ue=preg_replace('~_.*~','',$i);echo"<tr><td>".checkbox("databases[]",$i,$a==""||$a=="$Ue%",$i,"","block")."\n";$Ve[$Ue]++;}}}else
echo"<tr><td><textarea name='databases' rows='10' cols='20'></textarea>";}echo'</table>
</form>
';$sc=true;foreach($Ve
as$z=>$X){if($z!=""&&$X>1){echo($sc?"<p>":" ")."<a href='".h(ME)."dump=".urlencode("$z%")."'>".h($z)."</a>";$sc=false;}}}elseif(isset($_GET["privileges"])){page_header('Privileges');echo'<p class="links"><a href="'.h(ME).'user=">'.'Create user'."</a>";$J=$e->query("SELECT User, Host FROM mysql.".(DB==""?"user":"db WHERE ".q(DB)." LIKE Db")." ORDER BY Host, User");$r=$J;if(!$J)$J=$e->query("SELECT SUBSTRING_INDEX(CURRENT_USER, '@', 1) AS User, SUBSTRING_INDEX(CURRENT_USER, '@', -1) AS Host");echo"<form action=''><p>\n";hidden_fields_get();echo"<input type='hidden' name='db' value='".h(DB)."'>\n",($r?"":"<input type='hidden' name='grant' value=''>\n"),"<table cellspacing='0'>\n","<thead><tr><th>".'Username'."<th>".'Server'."<th></thead>\n";while($L=$J->fetch_assoc())echo'<tr'.odd().'><td>'.h($L["User"])."<td>".h($L["Host"]).'<td><a href="'.h(ME.'user='.urlencode($L["User"]).'&host='.urlencode($L["Host"])).'">'.'Edit'."</a>\n";if(!$r||DB!="")echo"<tr".odd()."><td><input name='user' autocapitalize='off'><td><input name='host' value='localhost' autocapitalize='off'><td><input type='submit' value='".'Edit'."'>\n";echo"</table>\n","</form>\n";}elseif(isset($_GET["sql"])){if(!$k&&$_POST["export"]){dump_headers("sql");$b->dumpTable("","");$b->dumpData("","table",$_POST["query"]);exit;}restart_session();$Nc=&get_session("queries");$Mc=&$Nc[DB];if(!$k&&$_POST["clear"]){$Mc=array();redirect(remove_from_uri("history"));}page_header((isset($_GET["import"])?'Import':'SQL command'),$k);if(!$k&&$_POST){$p=false;if(!isset($_GET["import"]))$I=$_POST["query"];elseif($_POST["webfile"]){$Vf=$b->importServerPath();$p=@fopen((file_exists($Vf)?$Vf:"compress.zlib://$Vf.gz"),"rb");$I=($p?fread($p,1e6):false);}else$I=get_file("sql_file",true);if(is_string($I)){if(function_exists('memory_get_usage'))@ini_set("memory_limit",max(ini_bytes("memory_limit"),2*strlen($I)+memory_get_usage()+8e6));if($I!=""&&strlen($I)<1e6){$H=$I.(preg_match("~;[ \t\r\n]*\$~",$I)?"":";");if(!$Mc||reset(end($Mc))!=$H){restart_session();$Mc[]=array($H,time());set_session("queries",$Nc);stop_session();}}$Tf="(?:\\s|/\\*[\s\S]*?\\*/|(?:#|-- )[^\n]*\n?|--\r?\n)";$zb=";";$ce=0;$Ub=true;$f=connect();if(is_object($f)&&DB!=""){$f->select_db(DB);if($_GET["ns"]!="")set_schema($_GET["ns"],$f);}$ab=0;$Zb=array();$Fe='[\'"'.($y=="sql"?'`#':($y=="sqlite"?'`[':($y=="mssql"?'[':''))).']|/\*|-- |$'.($y=="pgsql"?'|\$[^$]*\$':'');$Hg=microtime(true);parse_str($_COOKIE["adminer_export"],$la);$Lb=$b->dumpFormat();unset($Lb["sql"]);while($I!=""){if(!$ce&&preg_match("~^$Tf*+DELIMITER\\s+(\\S+)~i",$I,$C)){$zb=$C[1];$I=substr($I,strlen($C[0]));}else{preg_match('('.preg_quote($zb)."\\s*|$Fe)",$I,$C,PREG_OFFSET_CAPTURE,$ce);list($yc,$Qe)=$C[0];if(!$yc&&$p&&!feof($p))$I.=fread($p,1e5);else{if(!$yc&&rtrim($I)=="")break;$ce=$Qe+strlen($yc);if($yc&&rtrim($yc)!=$zb){while(preg_match('('.($yc=='/*'?'\*/':($yc=='['?']':(preg_match('~^-- |^#~',$yc)?"\n":preg_quote($yc)."|\\\\."))).'|$)s',$I,$C,PREG_OFFSET_CAPTURE,$ce)){$_f=$C[0][0];if(!$_f&&$p&&!feof($p))$I.=fread($p,1e5);else{$ce=$C[0][1]+strlen($_f);if($_f[0]!="\\")break;}}}else{$Ub=false;$H=substr($I,0,$Qe);$ab++;$Xe="<pre id='sql-$ab'><code class='jush-$y'>".$b->sqlCommandQuery($H)."</code></pre>\n";if($y=="sqlite"&&preg_match("~^$Tf*+ATTACH\\b~i",$H,$C)){echo$Xe,"<p class='error'>".'ATTACH queries are not supported.'."\n";$Zb[]=" <a href='#sql-$ab'>$ab</a>";if($_POST["error_stops"])break;}else{if(!$_POST["only_errors"]){echo$Xe;ob_flush();flush();}$Yf=microtime(true);if($e->multi_query($H)&&is_object($f)&&preg_match("~^$Tf*+USE\\b~i",$H))$f->query($H);do{$J=$e->store_result();if($e->error){echo($_POST["only_errors"]?$Xe:""),"<p class='error'>".'Error in query'.($e->errno?" ($e->errno)":"").": ".error()."\n";$Zb[]=" <a href='#sql-$ab'>$ab</a>";if($_POST["error_stops"])break
2;}else{$yg=" <span class='time'>(".format_time($Yf).")</span>".(strlen($H)<1000?" <a href='".h(ME)."sql=".urlencode(trim($H))."'>".'Edit'."</a>":"");$na=$e->affected_rows;$qh=($_POST["only_errors"]?"":$j->warnings());$rh="warnings-$ab";if($qh)$yg.=", <a href='#$rh'>".'Warnings'."</a>".script("qsl('a').onclick = partial(toggle, '$rh');","");$gc=null;$hc="explain-$ab";if(is_object($J)){$_=$_POST["limit"];$ue=select($J,$f,array(),$_);if(!$_POST["only_errors"]){echo"<form action='' method='post'>\n";$Zd=$J->num_rows;echo"<p>".($Zd?($_&&$Zd>$_?sprintf('%d / ',$_):"").lang(array('%d row','%d rows'),$Zd):""),$yg;if($f&&preg_match("~^($Tf|\\()*+SELECT\\b~i",$H)&&($gc=explain($f,$H)))echo", <a href='#$hc'>Explain</a>".script("qsl('a').onclick = partial(toggle, '$hc');","");$u="export-$ab";echo", <a href='#$u'>".'Export'."</a>".script("qsl('a').onclick = partial(toggle, '$u');","")."<span id='$u' class='hidden'>: ".html_select("output",$b->dumpOutput(),$la["output"])." ".html_select("format",$Lb,$la["format"])."<input type='hidden' name='query' value='".h($H)."'>"." <input type='submit' name='export' value='".'Export'."'><input type='hidden' name='token' value='$T'></span>\n"."</form>\n";}}else{if(preg_match("~^$Tf*+(CREATE|DROP|ALTER)$Tf++(DATABASE|SCHEMA)\\b~i",$H)){restart_session();set_session("dbs",null);stop_session();}if(!$_POST["only_errors"])echo"<p class='message' title='".h($e->info)."'>".lang(array('Query executed OK, %d row affected.','Query executed OK, %d rows affected.'),$na)."$yg\n";}echo($qh?"<div id='$rh' class='hidden'>\n$qh</div>\n":"");if($gc){echo"<div id='$hc' class='hidden'>\n";select($gc,$f,$ue);echo"</div>\n";}}$Yf=microtime(true);}while($e->next_result());}$I=substr($I,$ce);$ce=0;}}}}if($Ub)echo"<p class='message'>".'No commands to execute.'."\n";elseif($_POST["only_errors"]){echo"<p class='message'>".lang(array('%d query executed OK.','%d queries executed OK.'),$ab-count($Zb))," <span class='time'>(".format_time($Hg).")</span>\n";}elseif($Zb&&$ab>1)echo"<p class='error'>".'Error in query'.": ".implode("",$Zb)."\n";}else
echo"<p class='error'>".upload_error($I)."\n";}echo'
<form action="" method="post" enctype="multipart/form-data" id="form">
';$ec="<input type='submit' value='".'Execute'."' title='Ctrl+Enter'>";if(!isset($_GET["import"])){$H=$_GET["sql"];if($_POST)$H=$_POST["query"];elseif($_GET["history"]=="all")$H=$Mc;elseif($_GET["history"]!="")$H=$Mc[$_GET["history"]][0];echo"<p>";textarea("query",$H,20);echo
script(($_POST?"":"qs('textarea').focus();\n")."qs('#form').onsubmit = partial(sqlSubmit, qs('#form'), '".remove_from_uri("sql|limit|error_stops|only_errors")."');"),"<p>$ec\n",'Limit rows'.": <input type='number' name='limit' class='size' value='".h($_POST?$_POST["limit"]:$_GET["limit"])."'>\n";}else{echo"<fieldset><legend>".'File upload'."</legend><div>";$Fc=(extension_loaded("zlib")?"[.gz]":"");echo(ini_bool("file_uploads")?"SQL$Fc (&lt; ".ini_get("upload_max_filesize")."B): <input type='file' name='sql_file[]' multiple>\n$ec":'File uploads are disabled.'),"</div></fieldset>\n";$Tc=$b->importServerPath();if($Tc){echo"<fieldset><legend>".'From server'."</legend><div>",sprintf('Webserver file %s',"<code>".h($Tc)."$Fc</code>"),' <input type="submit" name="webfile" value="'.'Run file'.'">',"</div></fieldset>\n";}echo"<p>";}echo
checkbox("error_stops",1,($_POST?$_POST["error_stops"]:isset($_GET["import"])),'Stop on error')."\n",checkbox("only_errors",1,($_POST?$_POST["only_errors"]:isset($_GET["import"])),'Show only errors')."\n","<input type='hidden' name='token' value='$T'>\n";if(!isset($_GET["import"])&&$Mc){print_fieldset("history",'History',$_GET["history"]!="");for($X=end($Mc);$X;$X=prev($Mc)){$z=key($Mc);list($H,$yg,$Pb)=$X;echo'<a href="'.h(ME."sql=&history=$z").'">'.'Edit'."</a>"." <span class='time' title='".@date('Y-m-d',$yg)."'>".@date("H:i:s",$yg)."</span>"." <code class='jush-$y'>".shorten_utf8(ltrim(str_replace("\n"," ",str_replace("\r","",preg_replace('~^(#|-- ).*~m','',$H)))),80,"</code>").($Pb?" <span class='time'>($Pb)</span>":"")."<br>\n";}echo"<input type='submit' name='clear' value='".'Clear'."'>\n","<a href='".h(ME."sql=&history=all")."'>".'Edit all'."</a>\n","</div></fieldset>\n";}echo'</form>
';}elseif(isset($_GET["edit"])){$a=$_GET["edit"];$m=fields($a);$Z=(isset($_GET["select"])?($_POST["check"]&&count($_POST["check"])==1?where_check($_POST["check"][0],$m):""):where($_GET,$m));$Zg=(isset($_GET["select"])?$_POST["edit"]:$Z);foreach($m
as$E=>$l){if(!isset($l["privileges"][$Zg?"update":"insert"])||$b->fieldName($l)==""||$l["generated"])unset($m[$E]);}if($_POST&&!$k&&!isset($_GET["select"])){$B=$_POST["referer"];if($_POST["insert"])$B=($Zg?null:$_SERVER["REQUEST_URI"]);elseif(!preg_match('~^.+&select=.+$~',$B))$B=ME."select=".urlencode($a);$w=indexes($a);$Ug=unique_array($_GET["where"],$w);$gf="\nWHERE $Z";if(isset($_POST["delete"]))queries_redirect($B,'Item has been deleted.',$j->delete($a,$gf,!$Ug));else{$P=array();foreach($m
as$E=>$l){$X=process_input($l);if($X!==false&&$X!==null)$P[idf_escape($E)]=$X;}if($Zg){if(!$P)redirect($B);queries_redirect($B,'Item has been updated.',$j->update($a,$P,$gf,!$Ug));if(is_ajax()){page_headers();page_messages($k);exit;}}else{$J=$j->insert($a,$P);$pd=($J?last_id():0);queries_redirect($B,sprintf('Item%s has been inserted.',($pd?" $pd":"")),$J);}}}$L=null;if($_POST["save"])$L=(array)$_POST["fields"];elseif($Z){$N=array();foreach($m
as$E=>$l){if(isset($l["privileges"]["select"])){$ua=convert_field($l);if($_POST["clone"]&&$l["auto_increment"])$ua="''";if($y=="sql"&&preg_match("~enum|set~",$l["type"]))$ua="1*".idf_escape($E);$N[]=($ua?"$ua AS ":"").idf_escape($E);}}$L=array();if(!support("table"))$N=array("*");if($N){$J=$j->select($a,$N,array($Z),$N,array(),(isset($_GET["select"])?2:1));if(!$J)$k=error();else{$L=$J->fetch_assoc();if(!$L)$L=false;}if(isset($_GET["select"])&&(!$L||$J->fetch_assoc()))$L=null;}}if(!support("table")&&!$m){if(!$Z){$J=$j->select($a,array("*"),$Z,array("*"));$L=($J?$J->fetch_assoc():false);if(!$L)$L=array($j->primary=>"");}if($L){foreach($L
as$z=>$X){if(!$Z)$L[$z]=null;$m[$z]=array("field"=>$z,"null"=>($z!=$j->primary),"auto_increment"=>($z==$j->primary));}}}edit_form($a,$m,$L,$Zg);}elseif(isset($_GET["create"])){$a=$_GET["create"];$Ge=array();foreach(array('HASH','LINEAR HASH','KEY','LINEAR KEY','RANGE','LIST')as$z)$Ge[$z]=$z;$mf=referencable_primary($a);$o=array();foreach($mf
as$lg=>$l)$o[str_replace("`","``",$lg)."`".str_replace("`","``",$l["field"])]=$lg;$xe=array();$R=array();if($a!=""){$xe=fields($a);$R=table_status($a);if(!$R)$k='No tables.';}$L=$_POST;$L["fields"]=(array)$L["fields"];if($L["auto_increment_col"])$L["fields"][$L["auto_increment_col"]]["auto_increment"]=true;if($_POST)set_adminer_settings(array("comments"=>$_POST["comments"],"defaults"=>$_POST["defaults"]));if($_POST&&!process_fields($L["fields"])&&!$k){if($_POST["drop"])queries_redirect(substr(ME,0,-1),'Table has been dropped.',drop_tables(array($a)));else{$m=array();$ra=array();$dh=false;$vc=array();$we=reset($xe);$pa=" FIRST";foreach($L["fields"]as$z=>$l){$n=$o[$l["type"]];$Pg=($n!==null?$mf[$n]:$l);if($l["field"]!=""){if(!$l["has_default"])$l["default"]=null;if($z==$L["auto_increment_col"])$l["auto_increment"]=true;$cf=process_field($l,$Pg);$ra[]=array($l["orig"],$cf,$pa);if($cf!=process_field($we,$we)){$m[]=array($l["orig"],$cf,$pa);if($l["orig"]!=""||$pa)$dh=true;}if($n!==null)$vc[idf_escape($l["field"])]=($a!=""&&$y!="sqlite"?"ADD":" ").format_foreign_key(array('table'=>$o[$l["type"]],'source'=>array($l["field"]),'target'=>array($Pg["field"]),'on_delete'=>$l["on_delete"],));$pa=" AFTER ".idf_escape($l["field"]);}elseif($l["orig"]!=""){$dh=true;$m[]=array($l["orig"]);}if($l["orig"]!=""){$we=next($xe);if(!$we)$pa="";}}$Ie="";if($Ge[$L["partition_by"]]){$Je=array();if($L["partition_by"]=='RANGE'||$L["partition_by"]=='LIST'){foreach(array_filter($L["partition_names"])as$z=>$X){$Y=$L["partition_values"][$z];$Je[]="\n  PARTITION ".idf_escape($X)." VALUES ".($L["partition_by"]=='RANGE'?"LESS THAN":"IN").($Y!=""?" ($Y)":" MAXVALUE");}}$Ie.="\nPARTITION BY $L[partition_by]($L[partition])".($Je?" (".implode(",",$Je)."\n)":($L["partitions"]?" PARTITIONS ".(+$L["partitions"]):""));}elseif(support("partitioning")&&preg_match("~partitioned~",$R["Create_options"]))$Ie.="\nREMOVE PARTITIONING";$D='Table has been altered.';if($a==""){cookie("adminer_engine",$L["Engine"]);$D='Table has been created.';}$E=trim($L["name"]);queries_redirect(ME.(support("table")?"table=":"select=").urlencode($E),$D,alter_table($a,$E,($y=="sqlite"&&($dh||$vc)?$ra:$m),$vc,($L["Comment"]!=$R["Comment"]?$L["Comment"]:null),($L["Engine"]&&$L["Engine"]!=$R["Engine"]?$L["Engine"]:""),($L["Collation"]&&$L["Collation"]!=$R["Collation"]?$L["Collation"]:""),($L["Auto_increment"]!=""?number($L["Auto_increment"]):""),$Ie));}}page_header(($a!=""?'Alter table':'Create table'),$k,array("table"=>$a),h($a));if(!$_POST){$L=array("Engine"=>$_COOKIE["adminer_engine"],"fields"=>array(array("field"=>"","type"=>(isset($Rg["int"])?"int":(isset($Rg["integer"])?"integer":"")),"on_update"=>"")),"partition_names"=>array(""),);if($a!=""){$L=$R;$L["name"]=$a;$L["fields"]=array();if(!$_GET["auto_increment"])$L["Auto_increment"]="";foreach($xe
as$l){$l["has_default"]=isset($l["default"]);$L["fields"][]=$l;}if(support("partitioning")){$_c="FROM information_schema.PARTITIONS WHERE TABLE_SCHEMA = ".q(DB)." AND TABLE_NAME = ".q($a);$J=$e->query("SELECT PARTITION_METHOD, PARTITION_ORDINAL_POSITION, PARTITION_EXPRESSION $_c ORDER BY PARTITION_ORDINAL_POSITION DESC LIMIT 1");list($L["partition_by"],$L["partitions"],$L["partition"])=$J->fetch_row();$Je=get_key_vals("SELECT PARTITION_NAME, PARTITION_DESCRIPTION $_c AND PARTITION_NAME != '' ORDER BY PARTITION_ORDINAL_POSITION");$Je[""]="";$L["partition_names"]=array_keys($Je);$L["partition_values"]=array_values($Je);}}}$Xa=collations();$Wb=engines();foreach($Wb
as$Vb){if(!strcasecmp($Vb,$L["Engine"])){$L["Engine"]=$Vb;break;}}echo'
<form action="" method="post" id="form">
<p>
';if(support("columns")||$a==""){echo'Table name: <input name="name" data-maxlength="64" value="',h($L["name"]),'" autocapitalize="off">
';if($a==""&&!$_POST)echo
script("focus(qs('#form')['name']);");echo($Wb?"<select name='Engine'>".optionlist(array(""=>"(".'engine'.")")+$Wb,$L["Engine"])."</select>".on_help("getTarget(event).value",1).script("qsl('select').onchange = helpClose;"):""),' ',($Xa&&!preg_match("~sqlite|mssql~",$y)?html_select("Collation",array(""=>"(".'collation'.")")+$Xa,$L["Collation"]):""),' <input type="submit" value="Save">
';}echo'
';if(support("columns")){echo'<div class="scrollable">
<table cellspacing="0" id="edit-fields" class="nowrap">
';edit_fields($L["fields"],$Xa,"TABLE",$o);echo'</table>
</div>
<p>
Auto Increment: <input type="number" name="Auto_increment" size="6" value="',h($L["Auto_increment"]),'">
',checkbox("defaults",1,($_POST?$_POST["defaults"]:adminer_setting("defaults")),'Default values',"columnShow(this.checked, 5)","jsonly"),(support("comment")?checkbox("comments",1,($_POST?$_POST["comments"]:adminer_setting("comments")),'Comment',"editingCommentsClick(this, true);","jsonly").' <input name="Comment" value="'.h($L["Comment"]).'" data-maxlength="'.(min_version(5.5)?2048:60).'">':''),'<p>
<input type="submit" value="Save">
';}echo'
';if($a!=""){echo'<input type="submit" name="drop" value="Drop">',confirm(sprintf('Drop %s?',$a));}if(support("partitioning")){$He=preg_match('~RANGE|LIST~',$L["partition_by"]);print_fieldset("partition",'Partition by',$L["partition_by"]);echo'<p>
',"<select name='partition_by'>".optionlist(array(""=>"")+$Ge,$L["partition_by"])."</select>".on_help("getTarget(event).value.replace(/./, 'PARTITION BY \$&')",1).script("qsl('select').onchange = partitionByChange;"),'(<input name="partition" value="',h($L["partition"]),'">)
Partitions: <input type="number" name="partitions" class="size',($He||!$L["partition_by"]?" hidden":""),'" value="',h($L["partitions"]),'">
<table cellspacing="0" id="partition-table"',($He?"":" class='hidden'"),'>
<thead><tr><th>Partition name<th>Values</thead>
';foreach($L["partition_names"]as$z=>$X){echo'<tr>','<td><input name="partition_names[]" value="'.h($X).'" autocapitalize="off">',($z==count($L["partition_names"])-1?script("qsl('input').oninput = partitionNameChange;"):''),'<td><input name="partition_values[]" value="'.h($L["partition_values"][$z]).'">';}echo'</table>
</div></fieldset>
';}echo'<input type="hidden" name="token" value="',$T,'">
</form>
',script("qs('#form')['defaults'].onclick();".(support("comment")?" editingCommentsClick(qs('#form')['comments']);":""));}elseif(isset($_GET["indexes"])){$a=$_GET["indexes"];$Vc=array("PRIMARY","UNIQUE","INDEX");$R=table_status($a,true);if(preg_match('~MyISAM|M?aria'.(min_version(5.6,'10.0.5')?'|InnoDB':'').'~i',$R["Engine"]))$Vc[]="FULLTEXT";if(preg_match('~MyISAM|M?aria'.(min_version(5.7,'10.2.2')?'|InnoDB':'').'~i',$R["Engine"]))$Vc[]="SPATIAL";$w=indexes($a);$We=array();if($y=="mongo"){$We=$w["_id_"];unset($Vc[0]);unset($w["_id_"]);}$L=$_POST;if($_POST&&!$k&&!$_POST["add"]&&!$_POST["drop_col"]){$sa=array();foreach($L["indexes"]as$v){$E=$v["name"];if(in_array($v["type"],$Vc)){$d=array();$vd=array();$Ab=array();$P=array();ksort($v["columns"]);foreach($v["columns"]as$z=>$c){if($c!=""){$ud=$v["lengths"][$z];$_b=$v["descs"][$z];$P[]=idf_escape($c).($ud?"(".(+$ud).")":"").($_b?" DESC":"");$d[]=$c;$vd[]=($ud?$ud:null);$Ab[]=$_b;}}if($d){$fc=$w[$E];if($fc){ksort($fc["columns"]);ksort($fc["lengths"]);ksort($fc["descs"]);if($v["type"]==$fc["type"]&&array_values($fc["columns"])===$d&&(!$fc["lengths"]||array_values($fc["lengths"])===$vd)&&array_values($fc["descs"])===$Ab){unset($w[$E]);continue;}}$sa[]=array($v["type"],$E,$P);}}}foreach($w
as$E=>$fc)$sa[]=array($fc["type"],$E,"DROP");if(!$sa)redirect(ME."table=".urlencode($a));queries_redirect(ME."table=".urlencode($a),'Indexes have been altered.',alter_indexes($a,$sa));}page_header('Indexes',$k,array("table"=>$a),h($a));$m=array_keys(fields($a));if($_POST["add"]){foreach($L["indexes"]as$z=>$v){if($v["columns"][count($v["columns"])]!="")$L["indexes"][$z]["columns"][]="";}$v=end($L["indexes"]);if($v["type"]||array_filter($v["columns"],'strlen'))$L["indexes"][]=array("columns"=>array(1=>""));}if(!$L){foreach($w
as$z=>$v){$w[$z]["name"]=$z;$w[$z]["columns"][]="";}$w[]=array("columns"=>array(1=>""));$L["indexes"]=$w;}echo'
<form action="" method="post">
<div class="scrollable">
<table cellspacing="0" class="nowrap">
<thead><tr>
<th id="label-type">Index Type
<th><input type="submit" class="wayoff">Column (length)
<th id="label-name">Name
<th><noscript>',"<input type='image' class='icon' name='add[0]' src='".h(preg_replace("~\\?.*~","",ME)."?file=plus.gif&version=4.7.5")."' alt='+' title='".'Add next'."'>",'</noscript>
</thead>
';if($We){echo"<tr><td>PRIMARY<td>";foreach($We["columns"]as$z=>$c){echo
select_input(" disabled",$m,$c),"<label><input disabled type='checkbox'>".'descending'."</label> ";}echo"<td><td>\n";}$x=1;foreach($L["indexes"]as$v){if(!$_POST["drop_col"]||$x!=key($_POST["drop_col"])){echo"<tr><td>".html_select("indexes[$x][type]",array(-1=>"")+$Vc,$v["type"],($x==count($L["indexes"])?"indexesAddRow.call(this);":1),"label-type"),"<td>";ksort($v["columns"]);$t=1;foreach($v["columns"]as$z=>$c){echo"<span>".select_input(" name='indexes[$x][columns][$t]' title='".'Column'."'",($m?array_combine($m,$m):$m),$c,"partial(".($t==count($v["columns"])?"indexesAddColumn":"indexesChangeColumn").", '".js_escape($y=="sql"?"":$_GET["indexes"]."_")."')"),($y=="sql"||$y=="mssql"?"<input type='number' name='indexes[$x][lengths][$t]' class='size' value='".h($v["lengths"][$z])."' title='".'Length'."'>":""),(support("descidx")?checkbox("indexes[$x][descs][$t]",1,$v["descs"][$z],'descending'):"")," </span>";$t++;}echo"<td><input name='indexes[$x][name]' value='".h($v["name"])."' autocapitalize='off' aria-labelledby='label-name'>\n","<td><input type='image' class='icon' name='drop_col[$x]' src='".h(preg_replace("~\\?.*~","",ME)."?file=cross.gif&version=4.7.5")."' alt='x' title='".'Remove'."'>".script("qsl('input').onclick = partial(editingRemoveRow, 'indexes\$1[type]');");}$x++;}echo'</table>
</div>
<p>
<input type="submit" value="Save">
<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["database"])){$L=$_POST;if($_POST&&!$k&&!isset($_POST["add_x"])){$E=trim($L["name"]);if($_POST["drop"]){$_GET["db"]="";queries_redirect(remove_from_uri("db|database"),'Database has been dropped.',drop_databases(array(DB)));}elseif(DB!==$E){if(DB!=""){$_GET["db"]=$E;queries_redirect(preg_replace('~\bdb=[^&]*&~','',ME)."db=".urlencode($E),'Database has been renamed.',rename_database($E,$L["collation"]));}else{$h=explode("\n",str_replace("\r","",$E));$fg=true;$od="";foreach($h
as$i){if(count($h)==1||$i!=""){if(!create_database($i,$L["collation"]))$fg=false;$od=$i;}}restart_session();set_session("dbs",null);queries_redirect(ME."db=".urlencode($od),'Database has been created.',$fg);}}else{if(!$L["collation"])redirect(substr(ME,0,-1));query_redirect("ALTER DATABASE ".idf_escape($E).(preg_match('~^[a-z0-9_]+$~i',$L["collation"])?" COLLATE $L[collation]":""),substr(ME,0,-1),'Database has been altered.');}}page_header(DB!=""?'Alter database':'Create database',$k,array(),h(DB));$Xa=collations();$E=DB;if($_POST)$E=$L["name"];elseif(DB!="")$L["collation"]=db_collation(DB,$Xa);elseif($y=="sql"){foreach(get_vals("SHOW GRANTS")as$r){if(preg_match('~ ON (`(([^\\\\`]|``|\\\\.)*)%`\.\*)?~',$r,$C)&&$C[1]){$E=stripcslashes(idf_unescape("`$C[2]`"));break;}}}echo'
<form action="" method="post">
<p>
',($_POST["add_x"]||strpos($E,"\n")?'<textarea id="name" name="name" rows="10" cols="40">'.h($E).'</textarea><br>':'<input name="name" id="name" value="'.h($E).'" data-maxlength="64" autocapitalize="off">')."\n".($Xa?html_select("collation",array(""=>"(".'collation'.")")+$Xa,$L["collation"]).doc_link(array('sql'=>"charset-charsets.html",'mariadb'=>"supported-character-sets-and-collations/",)):""),script("focus(qs('#name'));"),'<input type="submit" value="Save">
';if(DB!="")echo"<input type='submit' name='drop' value='".'Drop'."'>".confirm(sprintf('Drop %s?',DB))."\n";elseif(!$_POST["add_x"]&&$_GET["db"]=="")echo"<input type='image' class='icon' name='add' src='".h(preg_replace("~\\?.*~","",ME)."?file=plus.gif&version=4.7.5")."' alt='+' title='".'Add next'."'>\n";echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["call"])){$da=($_GET["name"]?$_GET["name"]:$_GET["call"]);page_header('Call'.": ".h($da),$k);$xf=routine($_GET["call"],(isset($_GET["callf"])?"FUNCTION":"PROCEDURE"));$Uc=array();$_e=array();foreach($xf["fields"]as$t=>$l){if(substr($l["inout"],-3)=="OUT")$_e[$t]="@".idf_escape($l["field"])." AS ".idf_escape($l["field"]);if(!$l["inout"]||substr($l["inout"],0,2)=="IN")$Uc[]=$t;}if(!$k&&$_POST){$Ja=array();foreach($xf["fields"]as$z=>$l){if(in_array($z,$Uc)){$X=process_input($l);if($X===false)$X="''";if(isset($_e[$z]))$e->query("SET @".idf_escape($l["field"])." = $X");}$Ja[]=(isset($_e[$z])?"@".idf_escape($l["field"]):$X);}$I=(isset($_GET["callf"])?"SELECT":"CALL")." ".table($da)."(".implode(", ",$Ja).")";$Yf=microtime(true);$J=$e->multi_query($I);$na=$e->affected_rows;echo$b->selectQuery($I,$Yf,!$J);if(!$J)echo"<p class='error'>".error()."\n";else{$f=connect();if(is_object($f))$f->select_db(DB);do{$J=$e->store_result();if(is_object($J))select($J,$f);else
echo"<p class='message'>".lang(array('Routine has been called, %d row affected.','Routine has been called, %d rows affected.'),$na)."\n";}while($e->next_result());if($_e)select($e->query("SELECT ".implode(", ",$_e)));}}echo'
<form action="" method="post">
';if($Uc){echo"<table cellspacing='0' class='layout'>\n";foreach($Uc
as$z){$l=$xf["fields"][$z];$E=$l["field"];echo"<tr><th>".$b->fieldName($l);$Y=$_POST["fields"][$E];if($Y!=""){if($l["type"]=="enum")$Y=+$Y;if($l["type"]=="set")$Y=array_sum($Y);}input($l,$Y,(string)$_POST["function"][$E]);echo"\n";}echo"</table>\n";}echo'<p>
<input type="submit" value="Call">
<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["foreign"])){$a=$_GET["foreign"];$E=$_GET["name"];$L=$_POST;if($_POST&&!$k&&!$_POST["add"]&&!$_POST["change"]&&!$_POST["change-js"]){$D=($_POST["drop"]?'Foreign key has been dropped.':($E!=""?'Foreign key has been altered.':'Foreign key has been created.'));$B=ME."table=".urlencode($a);if(!$_POST["drop"]){$L["source"]=array_filter($L["source"],'strlen');ksort($L["source"]);$sg=array();foreach($L["source"]as$z=>$X)$sg[$z]=$L["target"][$z];$L["target"]=$sg;}if($y=="sqlite")queries_redirect($B,$D,recreate_table($a,$a,array(),array(),array(" $E"=>($_POST["drop"]?"":" ".format_foreign_key($L)))));else{$sa="ALTER TABLE ".table($a);$Hb="\nDROP ".($y=="sql"?"FOREIGN KEY ":"CONSTRAINT ").idf_escape($E);if($_POST["drop"])query_redirect($sa.$Hb,$B,$D);else{query_redirect($sa.($E!=""?"$Hb,":"")."\nADD".format_foreign_key($L),$B,$D);$k='Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.'."<br>$k";}}}page_header('Foreign key',$k,array("table"=>$a),h($a));if($_POST){ksort($L["source"]);if($_POST["add"])$L["source"][]="";elseif($_POST["change"]||$_POST["change-js"])$L["target"]=array();}elseif($E!=""){$o=foreign_keys($a);$L=$o[$E];$L["source"][]="";}else{$L["table"]=$a;$L["source"]=array("");}echo'
<form action="" method="post">
';$Sf=array_keys(fields($a));if($L["db"]!="")$e->select_db($L["db"]);if($L["ns"]!="")set_schema($L["ns"]);$lf=array_keys(array_filter(table_status('',true),'fk_support'));$sg=($a===$L["table"]?$Sf:array_keys(fields(in_array($L["table"],$lf)?$L["table"]:reset($lf))));$ke="this.form['change-js'].value = '1'; this.form.submit();";echo"<p>".'Target table'.": ".html_select("table",$lf,$L["table"],$ke)."\n";if($y=="pgsql")echo'Schema'.": ".html_select("ns",$b->schemas(),$L["ns"]!=""?$L["ns"]:$_GET["ns"],$ke);elseif($y!="sqlite"){$vb=array();foreach($b->databases()as$i){if(!information_schema($i))$vb[]=$i;}echo'DB'.": ".html_select("db",$vb,$L["db"]!=""?$L["db"]:$_GET["db"],$ke);}echo'<input type="hidden" name="change-js" value="">
<noscript><p><input type="submit" name="change" value="Change"></noscript>
<table cellspacing="0">
<thead><tr><th id="label-source">Source<th id="label-target">Target</thead>
';$x=0;foreach($L["source"]as$z=>$X){echo"<tr>","<td>".html_select("source[".(+$z)."]",array(-1=>"")+$Sf,$X,($x==count($L["source"])-1?"foreignAddRow.call(this);":1),"label-source"),"<td>".html_select("target[".(+$z)."]",$sg,$L["target"][$z],1,"label-target");$x++;}echo'</table>
<p>
ON DELETE: ',html_select("on_delete",array(-1=>"")+explode("|",$je),$L["on_delete"]),' ON UPDATE: ',html_select("on_update",array(-1=>"")+explode("|",$je),$L["on_update"]),doc_link(array('sql'=>"innodb-foreign-key-constraints.html",'mariadb'=>"foreign-keys/",)),'<p>
<input type="submit" value="Save">
<noscript><p><input type="submit" name="add" value="Add column"></noscript>
';if($E!=""){echo'<input type="submit" name="drop" value="Drop">',confirm(sprintf('Drop %s?',$E));}echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["view"])){$a=$_GET["view"];$L=$_POST;$ye="VIEW";if($y=="pgsql"&&$a!=""){$Zf=table_status($a);$ye=strtoupper($Zf["Engine"]);}if($_POST&&!$k){$E=trim($L["name"]);$ua=" AS\n$L[select]";$B=ME."table=".urlencode($E);$D='View has been altered.';$U=($_POST["materialized"]?"MATERIALIZED VIEW":"VIEW");if(!$_POST["drop"]&&$a==$E&&$y!="sqlite"&&$U=="VIEW"&&$ye=="VIEW")query_redirect(($y=="mssql"?"ALTER":"CREATE OR REPLACE")." VIEW ".table($E).$ua,$B,$D);else{$ug=$E."_adminer_".uniqid();drop_create("DROP $ye ".table($a),"CREATE $U ".table($E).$ua,"DROP $U ".table($E),"CREATE $U ".table($ug).$ua,"DROP $U ".table($ug),($_POST["drop"]?substr(ME,0,-1):$B),'View has been dropped.',$D,'View has been created.',$a,$E);}}if(!$_POST&&$a!=""){$L=view($a);$L["name"]=$a;$L["materialized"]=($ye!="VIEW");if(!$k)$k=error();}page_header(($a!=""?'Alter view':'Create view'),$k,array("table"=>$a),h($a));echo'
<form action="" method="post">
<p>Name: <input name="name" value="',h($L["name"]),'" data-maxlength="64" autocapitalize="off">
',(support("materializedview")?" ".checkbox("materialized",1,$L["materialized"],'Materialized view'):""),'<p>';textarea("select",$L["select"]);echo'<p>
<input type="submit" value="Save">
';if($a!=""){echo'<input type="submit" name="drop" value="Drop">',confirm(sprintf('Drop %s?',$a));}echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["event"])){$aa=$_GET["event"];$ad=array("YEAR","QUARTER","MONTH","DAY","HOUR","MINUTE","WEEK","SECOND","YEAR_MONTH","DAY_HOUR","DAY_MINUTE","DAY_SECOND","HOUR_MINUTE","HOUR_SECOND","MINUTE_SECOND");$ag=array("ENABLED"=>"ENABLE","DISABLED"=>"DISABLE","SLAVESIDE_DISABLED"=>"DISABLE ON SLAVE");$L=$_POST;if($_POST&&!$k){if($_POST["drop"])query_redirect("DROP EVENT ".idf_escape($aa),substr(ME,0,-1),'Event has been dropped.');elseif(in_array($L["INTERVAL_FIELD"],$ad)&&isset($ag[$L["STATUS"]])){$Af="\nON SCHEDULE ".($L["INTERVAL_VALUE"]?"EVERY ".q($L["INTERVAL_VALUE"])." $L[INTERVAL_FIELD]".($L["STARTS"]?" STARTS ".q($L["STARTS"]):"").($L["ENDS"]?" ENDS ".q($L["ENDS"]):""):"AT ".q($L["STARTS"]))." ON COMPLETION".($L["ON_COMPLETION"]?"":" NOT")." PRESERVE";queries_redirect(substr(ME,0,-1),($aa!=""?'Event has been altered.':'Event has been created.'),queries(($aa!=""?"ALTER EVENT ".idf_escape($aa).$Af.($aa!=$L["EVENT_NAME"]?"\nRENAME TO ".idf_escape($L["EVENT_NAME"]):""):"CREATE EVENT ".idf_escape($L["EVENT_NAME"]).$Af)."\n".$ag[$L["STATUS"]]." COMMENT ".q($L["EVENT_COMMENT"]).rtrim(" DO\n$L[EVENT_DEFINITION]",";").";"));}}page_header(($aa!=""?'Alter event'.": ".h($aa):'Create event'),$k);if(!$L&&$aa!=""){$M=get_rows("SELECT * FROM information_schema.EVENTS WHERE EVENT_SCHEMA = ".q(DB)." AND EVENT_NAME = ".q($aa));$L=reset($M);}echo'
<form action="" method="post">
<table cellspacing="0" class="layout">
<tr><th>Name<td><input name="EVENT_NAME" value="',h($L["EVENT_NAME"]),'" data-maxlength="64" autocapitalize="off">
<tr><th title="datetime">Start<td><input name="STARTS" value="',h("$L[EXECUTE_AT]$L[STARTS]"),'">
<tr><th title="datetime">End<td><input name="ENDS" value="',h($L["ENDS"]),'">
<tr><th>Every<td><input type="number" name="INTERVAL_VALUE" value="',h($L["INTERVAL_VALUE"]),'" class="size"> ',html_select("INTERVAL_FIELD",$ad,$L["INTERVAL_FIELD"]),'<tr><th>Status<td>',html_select("STATUS",$ag,$L["STATUS"]),'<tr><th>Comment<td><input name="EVENT_COMMENT" value="',h($L["EVENT_COMMENT"]),'" data-maxlength="64">
<tr><th><td>',checkbox("ON_COMPLETION","PRESERVE",$L["ON_COMPLETION"]=="PRESERVE",'On completion preserve'),'</table>
<p>';textarea("EVENT_DEFINITION",$L["EVENT_DEFINITION"]);echo'<p>
<input type="submit" value="Save">
';if($aa!=""){echo'<input type="submit" name="drop" value="Drop">',confirm(sprintf('Drop %s?',$aa));}echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["procedure"])){$da=($_GET["name"]?$_GET["name"]:$_GET["procedure"]);$xf=(isset($_GET["function"])?"FUNCTION":"PROCEDURE");$L=$_POST;$L["fields"]=(array)$L["fields"];if($_POST&&!process_fields($L["fields"])&&!$k){$ve=routine($_GET["procedure"],$xf);$ug="$L[name]_adminer_".uniqid();drop_create("DROP $xf ".routine_id($da,$ve),create_routine($xf,$L),"DROP $xf ".routine_id($L["name"],$L),create_routine($xf,array("name"=>$ug)+$L),"DROP $xf ".routine_id($ug,$L),substr(ME,0,-1),'Routine has been dropped.','Routine has been altered.','Routine has been created.',$da,$L["name"]);}page_header(($da!=""?(isset($_GET["function"])?'Alter function':'Alter procedure').": ".h($da):(isset($_GET["function"])?'Create function':'Create procedure')),$k);if(!$_POST&&$da!=""){$L=routine($_GET["procedure"],$xf);$L["name"]=$da;}$Xa=get_vals("SHOW CHARACTER SET");sort($Xa);$yf=routine_languages();echo'
<form action="" method="post" id="form">
<p>Name: <input name="name" value="',h($L["name"]),'" data-maxlength="64" autocapitalize="off">
',($yf?'Language'.": ".html_select("language",$yf,$L["language"])."\n":""),'<input type="submit" value="Save">
<div class="scrollable">
<table cellspacing="0" class="nowrap">
';edit_fields($L["fields"],$Xa,$xf);if(isset($_GET["function"])){echo"<tr><td>".'Return type';edit_type("returns",$L["returns"],$Xa,array(),($y=="pgsql"?array("void","trigger"):array()));}echo'</table>
</div>
<p>';textarea("definition",$L["definition"]);echo'<p>
<input type="submit" value="Save">
';if($da!=""){echo'<input type="submit" name="drop" value="Drop">',confirm(sprintf('Drop %s?',$da));}echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["trigger"])){$a=$_GET["trigger"];$E=$_GET["name"];$Ng=trigger_options();$L=(array)trigger($E)+array("Trigger"=>$a."_bi");if($_POST){if(!$k&&in_array($_POST["Timing"],$Ng["Timing"])&&in_array($_POST["Event"],$Ng["Event"])&&in_array($_POST["Type"],$Ng["Type"])){$ie=" ON ".table($a);$Hb="DROP TRIGGER ".idf_escape($E).($y=="pgsql"?$ie:"");$B=ME."table=".urlencode($a);if($_POST["drop"])query_redirect($Hb,$B,'Trigger has been dropped.');else{if($E!="")queries($Hb);queries_redirect($B,($E!=""?'Trigger has been altered.':'Trigger has been created.'),queries(create_trigger($ie,$_POST)));if($E!="")queries(create_trigger($ie,$L+array("Type"=>reset($Ng["Type"]))));}}$L=$_POST;}page_header(($E!=""?'Alter trigger'.": ".h($E):'Create trigger'),$k,array("table"=>$a));echo'
<form action="" method="post" id="form">
<table cellspacing="0" class="layout">
<tr><th>Time<td>',html_select("Timing",$Ng["Timing"],$L["Timing"],"triggerChange(/^".preg_quote($a,"/")."_[ba][iud]$/, '".js_escape($a)."', this.form);"),'<tr><th>Event<td>',html_select("Event",$Ng["Event"],$L["Event"],"this.form['Timing'].onchange();"),(in_array("UPDATE OF",$Ng["Event"])?" <input name='Of' value='".h($L["Of"])."' class='hidden'>":""),'<tr><th>Type<td>',html_select("Type",$Ng["Type"],$L["Type"]),'</table>
<p>Name: <input name="Trigger" value="',h($L["Trigger"]),'" data-maxlength="64" autocapitalize="off">
',script("qs('#form')['Timing'].onchange();"),'<p>';textarea("Statement",$L["Statement"]);echo'<p>
<input type="submit" value="Save">
';if($E!=""){echo'<input type="submit" name="drop" value="Drop">',confirm(sprintf('Drop %s?',$E));}echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["user"])){$fa=$_GET["user"];$af=array(""=>array("All privileges"=>""));foreach(get_rows("SHOW PRIVILEGES")as$L){foreach(explode(",",($L["Privilege"]=="Grant option"?"":$L["Context"]))as$gb)$af[$gb][$L["Privilege"]]=$L["Comment"];}$af["Server Admin"]+=$af["File access on server"];$af["Databases"]["Create routine"]=$af["Procedures"]["Create routine"];unset($af["Procedures"]["Create routine"]);$af["Columns"]=array();foreach(array("Select","Insert","Update","References")as$X)$af["Columns"][$X]=$af["Tables"][$X];unset($af["Server Admin"]["Usage"]);foreach($af["Tables"]as$z=>$X)unset($af["Databases"][$z]);$Td=array();if($_POST){foreach($_POST["objects"]as$z=>$X)$Td[$X]=(array)$Td[$X]+(array)$_POST["grants"][$z];}$Bc=array();$ge="";if(isset($_GET["host"])&&($J=$e->query("SHOW GRANTS FOR ".q($fa)."@".q($_GET["host"])))){while($L=$J->fetch_row()){if(preg_match('~GRANT (.*) ON (.*) TO ~',$L[0],$C)&&preg_match_all('~ *([^(,]*[^ ,(])( *\([^)]+\))?~',$C[1],$Bd,PREG_SET_ORDER)){foreach($Bd
as$X){if($X[1]!="USAGE")$Bc["$C[2]$X[2]"][$X[1]]=true;if(preg_match('~ WITH GRANT OPTION~',$L[0]))$Bc["$C[2]$X[2]"]["GRANT OPTION"]=true;}}if(preg_match("~ IDENTIFIED BY PASSWORD '([^']+)~",$L[0],$C))$ge=$C[1];}}if($_POST&&!$k){$he=(isset($_GET["host"])?q($fa)."@".q($_GET["host"]):"''");if($_POST["drop"])query_redirect("DROP USER $he",ME."privileges=",'User has been dropped.');else{$Vd=q($_POST["user"])."@".q($_POST["host"]);$Ke=$_POST["pass"];if($Ke!=''&&!$_POST["hashed"]&&!min_version(8)){$Ke=$e->result("SELECT PASSWORD(".q($Ke).")");$k=!$Ke;}$kb=false;if(!$k){if($he!=$Vd){$kb=queries((min_version(5)?"CREATE USER":"GRANT USAGE ON *.* TO")." $Vd IDENTIFIED BY ".(min_version(8)?"":"PASSWORD ").q($Ke));$k=!$kb;}elseif($Ke!=$ge)queries("SET PASSWORD FOR $Vd = ".q($Ke));}if(!$k){$uf=array();foreach($Td
as$be=>$r){if(isset($_GET["grant"]))$r=array_filter($r);$r=array_keys($r);if(isset($_GET["grant"]))$uf=array_diff(array_keys(array_filter($Td[$be],'strlen')),$r);elseif($he==$Vd){$ee=array_keys((array)$Bc[$be]);$uf=array_diff($ee,$r);$r=array_diff($r,$ee);unset($Bc[$be]);}if(preg_match('~^(.+)\s*(\(.*\))?$~U',$be,$C)&&(!grant("REVOKE",$uf,$C[2]," ON $C[1] FROM $Vd")||!grant("GRANT",$r,$C[2]," ON $C[1] TO $Vd"))){$k=true;break;}}}if(!$k&&isset($_GET["host"])){if($he!=$Vd)queries("DROP USER $he");elseif(!isset($_GET["grant"])){foreach($Bc
as$be=>$uf){if(preg_match('~^(.+)(\(.*\))?$~U',$be,$C))grant("REVOKE",array_keys($uf),$C[2]," ON $C[1] FROM $Vd");}}}queries_redirect(ME."privileges=",(isset($_GET["host"])?'User has been altered.':'User has been created.'),!$k);if($kb)$e->query("DROP USER $Vd");}}page_header((isset($_GET["host"])?'Username'.": ".h("$fa@$_GET[host]"):'Create user'),$k,array("privileges"=>array('','Privileges')));if($_POST){$L=$_POST;$Bc=$Td;}else{$L=$_GET+array("host"=>$e->result("SELECT SUBSTRING_INDEX(CURRENT_USER, '@', -1)"));$L["pass"]=$ge;if($ge!="")$L["hashed"]=true;$Bc[(DB==""||$Bc?"":idf_escape(addcslashes(DB,"%_\\"))).".*"]=array();}echo'<form action="" method="post">
<table cellspacing="0" class="layout">
<tr><th>Server<td><input name="host" data-maxlength="60" value="',h($L["host"]),'" autocapitalize="off">
<tr><th>Username<td><input name="user" data-maxlength="80" value="',h($L["user"]),'" autocapitalize="off">
<tr><th>Password<td><input name="pass" id="pass" value="',h($L["pass"]),'" autocomplete="new-password">
';if(!$L["hashed"])echo
script("typePassword(qs('#pass'));");echo(min_version(8)?"":checkbox("hashed",1,$L["hashed"],'Hashed',"typePassword(this.form['pass'], this.checked);")),'</table>

';echo"<table cellspacing='0'>\n","<thead><tr><th colspan='2'>".'Privileges'.doc_link(array('sql'=>"grant.html#priv_level"));$t=0;foreach($Bc
as$be=>$r){echo'<th>'.($be!="*.*"?"<input name='objects[$t]' value='".h($be)."' size='10' autocapitalize='off'>":"<input type='hidden' name='objects[$t]' value='*.*' size='10'>*.*");$t++;}echo"</thead>\n";foreach(array(""=>"","Server Admin"=>'Server',"Databases"=>'Database',"Tables"=>'Table',"Columns"=>'Column',"Procedures"=>'Routine',)as$gb=>$_b){foreach((array)$af[$gb]as$Ze=>$bb){echo"<tr".odd()."><td".($_b?">$_b<td":" colspan='2'").' lang="en" title="'.h($bb).'">'.h($Ze);$t=0;foreach($Bc
as$be=>$r){$E="'grants[$t][".h(strtoupper($Ze))."]'";$Y=$r[strtoupper($Ze)];if($gb=="Server Admin"&&$be!=(isset($Bc["*.*"])?"*.*":".*"))echo"<td>";elseif(isset($_GET["grant"]))echo"<td><select name=$E><option><option value='1'".($Y?" selected":"").">".'Grant'."<option value='0'".($Y=="0"?" selected":"").">".'Revoke'."</select>";else{echo"<td align='center'><label class='block'>","<input type='checkbox' name=$E value='1'".($Y?" checked":"").($Ze=="All privileges"?" id='grants-$t-all'>":">".($Ze=="Grant option"?"":script("qsl('input').onclick = function () { if (this.checked) formUncheck('grants-$t-all'); };"))),"</label>";}$t++;}}}echo"</table>\n",'<p>
<input type="submit" value="Save">
';if(isset($_GET["host"])){echo'<input type="submit" name="drop" value="Drop">',confirm(sprintf('Drop %s?',"$fa@$_GET[host]"));}echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["processlist"])){if(support("kill")&&$_POST&&!$k){$kd=0;foreach((array)$_POST["kill"]as$X){if(kill_process($X))$kd++;}queries_redirect(ME."processlist=",lang(array('%d process has been killed.','%d processes have been killed.'),$kd),$kd||!$_POST["kill"]);}page_header('Process list',$k);echo'
<form action="" method="post">
<div class="scrollable">
<table cellspacing="0" class="nowrap checkable">
',script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});");$t=-1;foreach(process_list()as$t=>$L){if(!$t){echo"<thead><tr lang='en'>".(support("kill")?"<th>":"");foreach($L
as$z=>$X)echo"<th>$z".doc_link(array('sql'=>"show-processlist.html#processlist_".strtolower($z),));echo"</thead>\n";}echo"<tr".odd().">".(support("kill")?"<td>".checkbox("kill[]",$L[$y=="sql"?"Id":"pid"],0):"");foreach($L
as$z=>$X)echo"<td>".(($y=="sql"&&$z=="Info"&&preg_match("~Query|Killed~",$L["Command"])&&$X!="")||($y=="pgsql"&&$z=="current_query"&&$X!="<IDLE>")||($y=="oracle"&&$z=="sql_text"&&$X!="")?"<code class='jush-$y'>".shorten_utf8($X,100,"</code>").' <a href="'.h(ME.($L["db"]!=""?"db=".urlencode($L["db"])."&":"")."sql=".urlencode($X)).'">'.'Clone'.'</a>':h($X));echo"\n";}echo'</table>
</div>
<p>
';if(support("kill")){echo($t+1)."/".sprintf('%d in total',max_connections()),"<p><input type='submit' value='".'Kill'."'>\n";}echo'<input type="hidden" name="token" value="',$T,'">
</form>
',script("tableCheck();");}elseif(isset($_GET["select"])){$a=$_GET["select"];$R=table_status1($a);$w=indexes($a);$m=fields($a);$o=column_foreign_keys($a);$de=$R["Oid"];parse_str($_COOKIE["adminer_import"],$ma);$vf=array();$d=array();$xg=null;foreach($m
as$z=>$l){$E=$b->fieldName($l);if(isset($l["privileges"]["select"])&&$E!=""){$d[$z]=html_entity_decode(strip_tags($E),ENT_QUOTES);if(is_shortable($l))$xg=$b->selectLengthProcess();}$vf+=$l["privileges"];}list($N,$s)=$b->selectColumnsProcess($d,$w);$ed=count($s)<count($N);$Z=$b->selectSearchProcess($m,$w);$re=$b->selectOrderProcess($m,$w);$_=$b->selectLimitProcess();if($_GET["val"]&&is_ajax()){header("Content-Type: text/plain; charset=utf-8");foreach($_GET["val"]as$Vg=>$L){$ua=convert_field($m[key($L)]);$N=array($ua?$ua:idf_escape(key($L)));$Z[]=where_check($Vg,$m);$K=$j->select($a,$N,$Z,$N);if($K)echo
reset($K->fetch_row());}exit;}$We=$Xg=null;foreach($w
as$v){if($v["type"]=="PRIMARY"){$We=array_flip($v["columns"]);$Xg=($N?$We:array());foreach($Xg
as$z=>$X){if(in_array(idf_escape($z),$N))unset($Xg[$z]);}break;}}if($de&&!$We){$We=$Xg=array($de=>0);$w[]=array("type"=>"PRIMARY","columns"=>array($de));}if($_POST&&!$k){$th=$Z;if(!$_POST["all"]&&is_array($_POST["check"])){$Oa=array();foreach($_POST["check"]as$Ma)$Oa[]=where_check($Ma,$m);$th[]="((".implode(") OR (",$Oa)."))";}$th=($th?"\nWHERE ".implode(" AND ",$th):"");if($_POST["export"]){cookie("adminer_import","output=".urlencode($_POST["output"])."&format=".urlencode($_POST["format"]));dump_headers($a);$b->dumpTable($a,"");$_c=($N?implode(", ",$N):"*").convert_fields($d,$m,$N)."\nFROM ".table($a);$Dc=($s&&$ed?"\nGROUP BY ".implode(", ",$s):"").($re?"\nORDER BY ".implode(", ",$re):"");if(!is_array($_POST["check"])||$We)$I="SELECT $_c$th$Dc";else{$Tg=array();foreach($_POST["check"]as$X)$Tg[]="(SELECT".limit($_c,"\nWHERE ".($Z?implode(" AND ",$Z)." AND ":"").where_check($X,$m).$Dc,1).")";$I=implode(" UNION ALL ",$Tg);}$b->dumpData($a,"table",$I);exit;}if(!$b->selectEmailProcess($Z,$o)){if($_POST["save"]||$_POST["delete"]){$J=true;$na=0;$P=array();if(!$_POST["delete"]){foreach($d
as$E=>$X){$X=process_input($m[$E]);if($X!==null&&($_POST["clone"]||$X!==false))$P[idf_escape($E)]=($X!==false?$X:idf_escape($E));}}if($_POST["delete"]||$P){if($_POST["clone"])$I="INTO ".table($a)." (".implode(", ",array_keys($P)).")\nSELECT ".implode(", ",$P)."\nFROM ".table($a);if($_POST["all"]||($We&&is_array($_POST["check"]))||$ed){$J=($_POST["delete"]?$j->delete($a,$th):($_POST["clone"]?queries("INSERT $I$th"):$j->update($a,$P,$th)));$na=$e->affected_rows;}else{foreach((array)$_POST["check"]as$X){$sh="\nWHERE ".($Z?implode(" AND ",$Z)." AND ":"").where_check($X,$m);$J=($_POST["delete"]?$j->delete($a,$sh,1):($_POST["clone"]?queries("INSERT".limit1($a,$I,$sh)):$j->update($a,$P,$sh,1)));if(!$J)break;$na+=$e->affected_rows;}}}$D=lang(array('%d item has been affected.','%d items have been affected.'),$na);if($_POST["clone"]&&$J&&$na==1){$pd=last_id();if($pd)$D=sprintf('Item%s has been inserted.'," $pd");}queries_redirect(remove_from_uri($_POST["all"]&&$_POST["delete"]?"page":""),$D,$J);if(!$_POST["delete"]){edit_form($a,$m,(array)$_POST["fields"],!$_POST["clone"]);page_footer();exit;}}elseif(!$_POST["import"]){if(!$_POST["val"])$k='Ctrl+click on a value to modify it.';else{$J=true;$na=0;foreach($_POST["val"]as$Vg=>$L){$P=array();foreach($L
as$z=>$X){$z=bracket_escape($z,1);$P[idf_escape($z)]=(preg_match('~char|text~',$m[$z]["type"])||$X!=""?$b->processInput($m[$z],$X):"NULL");}$J=$j->update($a,$P," WHERE ".($Z?implode(" AND ",$Z)." AND ":"").where_check($Vg,$m),!$ed&&!$We," ");if(!$J)break;$na+=$e->affected_rows;}queries_redirect(remove_from_uri(),lang(array('%d item has been affected.','%d items have been affected.'),$na),$J);}}elseif(!is_string($pc=get_file("csv_file",true)))$k=upload_error($pc);elseif(!preg_match('~~u',$pc))$k='File must be in UTF-8 encoding.';else{cookie("adminer_import","output=".urlencode($ma["output"])."&format=".urlencode($_POST["separator"]));$J=true;$Ya=array_keys($m);preg_match_all('~(?>"[^"]*"|[^"\r\n]+)+~',$pc,$Bd);$na=count($Bd[0]);$j->begin();$If=($_POST["separator"]=="csv"?",":($_POST["separator"]=="tsv"?"\t":";"));$M=array();foreach($Bd[0]as$z=>$X){preg_match_all("~((?>\"[^\"]*\")+|[^$If]*)$If~",$X.$If,$Cd);if(!$z&&!array_diff($Cd[1],$Ya)){$Ya=$Cd[1];$na--;}else{$P=array();foreach($Cd[1]as$t=>$Ua)$P[idf_escape($Ya[$t])]=($Ua==""&&$m[$Ya[$t]]["null"]?"NULL":q(str_replace('""','"',preg_replace('~^"|"$~','',$Ua))));$M[]=$P;}}$J=(!$M||$j->insertUpdate($a,$M,$We));if($J)$J=$j->commit();queries_redirect(remove_from_uri("page"),lang(array('%d row has been imported.','%d rows have been imported.'),$na),$J);$j->rollback();}}}$lg=$b->tableName($R);if(is_ajax()){page_headers();ob_start();}else
page_header('Select'.": $lg",$k);$P=null;if(isset($vf["insert"])||!support("table")){$P="";foreach((array)$_GET["where"]as$X){if($o[$X["col"]]&&count($o[$X["col"]])==1&&($X["op"]=="="||(!$X["op"]&&!preg_match('~[_%]~',$X["val"]))))$P.="&set".urlencode("[".bracket_escape($X["col"])."]")."=".urlencode($X["val"]);}}$b->selectLinks($R,$P);if(!$d&&support("table"))echo"<p class='error'>".'Unable to select the table'.($m?".":": ".error())."\n";else{echo"<form action='' id='form'>\n","<div style='display: none;'>";hidden_fields_get();echo(DB!=""?'<input type="hidden" name="db" value="'.h(DB).'">'.(isset($_GET["ns"])?'<input type="hidden" name="ns" value="'.h($_GET["ns"]).'">':""):"");echo'<input type="hidden" name="select" value="'.h($a).'">',"</div>\n";$b->selectColumnsPrint($N,$d);$b->selectSearchPrint($Z,$d,$w);$b->selectOrderPrint($re,$d,$w);$b->selectLimitPrint($_);$b->selectLengthPrint($xg);$b->selectActionPrint($w);echo"</form>\n";$F=$_GET["page"];if($F=="last"){$zc=$e->result(count_rows($a,$Z,$ed,$s));$F=floor(max(0,$zc-1)/$_);}$Df=$N;$Cc=$s;if(!$Df){$Df[]="*";$hb=convert_fields($d,$m,$N);if($hb)$Df[]=substr($hb,2);}foreach($N
as$z=>$X){$l=$m[idf_unescape($X)];if($l&&($ua=convert_field($l)))$Df[$z]="$ua AS $X";}if(!$ed&&$Xg){foreach($Xg
as$z=>$X){$Df[]=idf_escape($z);if($Cc)$Cc[]=idf_escape($z);}}$J=$j->select($a,$Df,$Z,$Cc,$re,$_,$F,true);if(!$J)echo"<p class='error'>".error()."\n";else{if($y=="mssql"&&$F)$J->seek($_*$F);$Tb=array();echo"<form action='' method='post' enctype='multipart/form-data'>\n";$M=array();while($L=$J->fetch_assoc()){if($F&&$y=="oracle")unset($L["RNUM"]);$M[]=$L;}if($_GET["page"]!="last"&&$_!=""&&$s&&$ed&&$y=="sql")$zc=$e->result(" SELECT FOUND_ROWS()");if(!$M)echo"<p class='message'>".'No rows.'."\n";else{$Ba=$b->backwardKeys($a,$lg);echo"<div class='scrollable'>","<table id='table' cellspacing='0' class='nowrap checkable'>",script("mixin(qs('#table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true), onkeydown: editingKeydown});"),"<thead><tr>".(!$s&&$N?"":"<td><input type='checkbox' id='all-page' class='jsonly'>".script("qs('#all-page').onclick = partial(formCheck, /check/);","")." <a href='".h($_GET["modify"]?remove_from_uri("modify"):$_SERVER["REQUEST_URI"]."&modify=1")."'>".'Modify'."</a>");$Sd=array();$Ac=array();reset($N);$if=1;foreach($M[0]as$z=>$X){if(!isset($Xg[$z])){$X=$_GET["columns"][key($N)];$l=$m[$N?($X?$X["col"]:current($N)):$z];$E=($l?$b->fieldName($l,$if):($X["fun"]?"*":$z));if($E!=""){$if++;$Sd[$z]=$E;$c=idf_escape($z);$Pc=remove_from_uri('(order|desc)[^=]*|page').'&order%5B0%5D='.urlencode($z);$_b="&desc%5B0%5D=1";echo"<th>".script("mixin(qsl('th'), {onmouseover: partial(columnMouse), onmouseout: partial(columnMouse, ' hidden')});",""),'<a href="'.h($Pc.($re[0]==$c||$re[0]==$z||(!$re&&$ed&&$s[0]==$c)?$_b:'')).'">';echo
apply_sql_function($X["fun"],$E)."</a>";echo"<span class='column hidden'>","<a href='".h($Pc.$_b)."' title='".'descending'."' class='text'> ↓</a>";if(!$X["fun"]){echo'<a href="#fieldset-search" title="'.'Search'.'" class="text jsonly"> =</a>',script("qsl('a').onclick = partial(selectSearch, '".js_escape($z)."');");}echo"</span>";}$Ac[$z]=$X["fun"];next($N);}}$vd=array();if($_GET["modify"]){foreach($M
as$L){foreach($L
as$z=>$X)$vd[$z]=max($vd[$z],min(40,strlen(utf8_decode($X))));}}echo($Ba?"<th>".'Relations':"")."</thead>\n";if(is_ajax()){if($_%2==1&&$F%2==1)odd();ob_end_clean();}foreach($b->rowDescriptions($M,$o)as$Rd=>$L){$Ug=unique_array($M[$Rd],$w);if(!$Ug){$Ug=array();foreach($M[$Rd]as$z=>$X){if(!preg_match('~^(COUNT\((\*|(DISTINCT )?`(?:[^`]|``)+`)\)|(AVG|GROUP_CONCAT|MAX|MIN|SUM)\(`(?:[^`]|``)+`\))$~',$z))$Ug[$z]=$X;}}$Vg="";foreach($Ug
as$z=>$X){if(($y=="sql"||$y=="pgsql")&&preg_match('~char|text|enum|set~',$m[$z]["type"])&&strlen($X)>64){$z=(strpos($z,'(')?$z:idf_escape($z));$z="MD5(".($y!='sql'||preg_match("~^utf8~",$m[$z]["collation"])?$z:"CONVERT($z USING ".charset($e).")").")";$X=md5($X);}$Vg.="&".($X!==null?urlencode("where[".bracket_escape($z)."]")."=".urlencode($X):"null%5B%5D=".urlencode($z));}echo"<tr".odd().">".(!$s&&$N?"":"<td>".checkbox("check[]",substr($Vg,1),in_array(substr($Vg,1),(array)$_POST["check"])).($ed||information_schema(DB)?"":" <a href='".h(ME."edit=".urlencode($a).$Vg)."' class='edit'>".'edit'."</a>"));foreach($L
as$z=>$X){if(isset($Sd[$z])){$l=$m[$z];$X=$j->value($X,$l);if($X!=""&&(!isset($Tb[$z])||$Tb[$z]!=""))$Tb[$z]=(is_mail($X)?$Sd[$z]:"");$A="";if(preg_match('~blob|bytea|raw|file~',$l["type"])&&$X!="")$A=ME.'download='.urlencode($a).'&field='.urlencode($z).$Vg;if(!$A&&$X!==null){foreach((array)$o[$z]as$n){if(count($o[$z])==1||end($n["source"])==$z){$A="";foreach($n["source"]as$t=>$Sf)$A.=where_link($t,$n["target"][$t],$M[$Rd][$Sf]);$A=($n["db"]!=""?preg_replace('~([?&]db=)[^&]+~','\1'.urlencode($n["db"]),ME):ME).'select='.urlencode($n["table"]).$A;if($n["ns"])$A=preg_replace('~([?&]ns=)[^&]+~','\1'.urlencode($n["ns"]),$A);if(count($n["source"])==1)break;}}}if($z=="COUNT(*)"){$A=ME."select=".urlencode($a);$t=0;foreach((array)$_GET["where"]as$W){if(!array_key_exists($W["col"],$Ug))$A.=where_link($t++,$W["col"],$W["val"],$W["op"]);}foreach($Ug
as$hd=>$W)$A.=where_link($t++,$hd,$W);}$X=select_value($X,$A,$l,$xg);$u=h("val[$Vg][".bracket_escape($z)."]");$Y=$_POST["val"][$Vg][bracket_escape($z)];$Ob=!is_array($L[$z])&&is_utf8($X)&&$M[$Rd][$z]==$L[$z]&&!$Ac[$z];$wg=preg_match('~text|lob~',$l["type"]);echo"<td id='$u'";if(($_GET["modify"]&&$Ob)||$Y!==null){$Gc=h($Y!==null?$Y:$L[$z]);echo">".($wg?"<textarea name='$u' cols='30' rows='".(substr_count($L[$z],"\n")+1)."'>$Gc</textarea>":"<input name='$u' value='$Gc' size='$vd[$z]'>");}else{$zd=strpos($X,"<i>…</i>");echo" data-text='".($zd?2:($wg?1:0))."'".($Ob?"":" data-warning='".h('Use edit link to modify this value.')."'").">$X</td>";}}}if($Ba)echo"<td>";$b->backwardKeysPrint($Ba,$M[$Rd]);echo"</tr>\n";}if(is_ajax())exit;echo"</table>\n","</div>\n";}if(!is_ajax()){if($M||$F){$dc=true;if($_GET["page"]!="last"){if($_==""||(count($M)<$_&&($M||!$F)))$zc=($F?$F*$_:0)+count($M);elseif($y!="sql"||!$ed){$zc=($ed?false:found_rows($R,$Z));if($zc<max(1e4,2*($F+1)*$_))$zc=reset(slow_query(count_rows($a,$Z,$ed,$s)));else$dc=false;}}$Ce=($_!=""&&($zc===false||$zc>$_||$F));if($Ce){echo(($zc===false?count($M)+1:$zc-$F*$_)>$_?'<p><a href="'.h(remove_from_uri("page")."&page=".($F+1)).'" class="loadmore">'.'Load more data'.'</a>'.script("qsl('a').onclick = partial(selectLoadMore, ".(+$_).", '".'Loading'."…');",""):''),"\n";}}echo"<div class='footer'><div>\n";if($M||$F){if($Ce){$Ed=($zc===false?$F+(count($M)>=$_?2:1):floor(($zc-1)/$_));echo"<fieldset>";if($y!="simpledb"){echo"<legend><a href='".h(remove_from_uri("page"))."'>".'Page'."</a></legend>",script("qsl('a').onclick = function () { pageClick(this.href, +prompt('".'Page'."', '".($F+1)."')); return false; };"),pagination(0,$F).($F>5?" …":"");for($t=max(1,$F-4);$t<min($Ed,$F+5);$t++)echo
pagination($t,$F);if($Ed>0){echo($F+5<$Ed?" …":""),($dc&&$zc!==false?pagination($Ed,$F):" <a href='".h(remove_from_uri("page")."&page=last")."' title='~$Ed'>".'last'."</a>");}}else{echo"<legend>".'Page'."</legend>",pagination(0,$F).($F>1?" …":""),($F?pagination($F,$F):""),($Ed>$F?pagination($F+1,$F).($Ed>$F+1?" …":""):"");}echo"</fieldset>\n";}echo"<fieldset>","<legend>".'Whole result'."</legend>";$Eb=($dc?"":"~ ").$zc;echo
checkbox("all",1,0,($zc!==false?($dc?"":"~ ").lang(array('%d row','%d rows'),$zc):""),"var checked = formChecked(this, /check/); selectCount('selected', this.checked ? '$Eb' : checked); selectCount('selected2', this.checked || !checked ? '$Eb' : checked);")."\n","</fieldset>\n";if($b->selectCommandPrint()){echo'<fieldset',($_GET["modify"]?'':' class="jsonly"'),'><legend>Modify</legend><div>
<input type="submit" value="Save"',($_GET["modify"]?'':' title="'.'Ctrl+click on a value to modify it.'.'"'),'>
</div></fieldset>
<fieldset><legend>Selected <span id="selected"></span></legend><div>
<input type="submit" name="edit" value="Edit">
<input type="submit" name="clone" value="Clone">
<input type="submit" name="delete" value="Delete">',confirm(),'</div></fieldset>
';}$xc=$b->dumpFormat();foreach((array)$_GET["columns"]as$c){if($c["fun"]){unset($xc['sql']);break;}}if($xc){print_fieldset("export",'Export'." <span id='selected2'></span>");$Ae=$b->dumpOutput();echo($Ae?html_select("output",$Ae,$ma["output"])." ":""),html_select("format",$xc,$ma["format"])," <input type='submit' name='export' value='".'Export'."'>\n","</div></fieldset>\n";}$b->selectEmailPrint(array_filter($Tb,'strlen'),$d);}echo"</div></div>\n";if($b->selectImportPrint()){echo"<div>","<a href='#import'>".'Import'."</a>",script("qsl('a').onclick = partial(toggle, 'import');",""),"<span id='import' class='hidden'>: ","<input type='file' name='csv_file'> ",html_select("separator",array("csv"=>"CSV,","csv;"=>"CSV;","tsv"=>"TSV"),$ma["format"],1);echo" <input type='submit' name='import' value='".'Import'."'>","</span>","</div>";}echo"<input type='hidden' name='token' value='$T'>\n","</form>\n",(!$s&&$N?"":script("tableCheck();"));}}}if(is_ajax()){ob_end_clean();exit;}}elseif(isset($_GET["variables"])){$Zf=isset($_GET["status"]);page_header($Zf?'Status':'Variables');$jh=($Zf?show_status():show_variables());if(!$jh)echo"<p class='message'>".'No rows.'."\n";else{echo"<table cellspacing='0'>\n";foreach($jh
as$z=>$X){echo"<tr>","<th><code class='jush-".$y.($Zf?"status":"set")."'>".h($z)."</code>","<td>".h($X);}echo"</table>\n";}}elseif(isset($_GET["script"])){header("Content-Type: text/javascript; charset=utf-8");if($_GET["script"]=="db"){$ig=array("Data_length"=>0,"Index_length"=>0,"Data_free"=>0);foreach(table_status()as$E=>$R){json_row("Comment-$E",h($R["Comment"]));if(!is_view($R)){foreach(array("Engine","Collation")as$z)json_row("$z-$E",h($R[$z]));foreach($ig+array("Auto_increment"=>0,"Rows"=>0)as$z=>$X){if($R[$z]!=""){$X=format_number($R[$z]);json_row("$z-$E",($z=="Rows"&&$X&&$R["Engine"]==($Uf=="pgsql"?"table":"InnoDB")?"~ $X":$X));if(isset($ig[$z]))$ig[$z]+=($R["Engine"]!="InnoDB"||$z!="Data_free"?$R[$z]:0);}elseif(array_key_exists($z,$R))json_row("$z-$E");}}}foreach($ig
as$z=>$X)json_row("sum-$z",format_number($X));json_row("");}elseif($_GET["script"]=="kill")$e->query("KILL ".number($_POST["kill"]));else{foreach(count_tables($b->databases())as$i=>$X){json_row("tables-$i",$X);json_row("size-$i",db_size($i));}json_row("");}exit;}else{$qg=array_merge((array)$_POST["tables"],(array)$_POST["views"]);if($qg&&!$k&&!$_POST["search"]){$J=true;$D="";if($y=="sql"&&$_POST["tables"]&&count($_POST["tables"])>1&&($_POST["drop"]||$_POST["truncate"]||$_POST["copy"]))queries("SET foreign_key_checks = 0");if($_POST["truncate"]){if($_POST["tables"])$J=truncate_tables($_POST["tables"]);$D='Tables have been truncated.';}elseif($_POST["move"]){$J=move_tables((array)$_POST["tables"],(array)$_POST["views"],$_POST["target"]);$D='Tables have been moved.';}elseif($_POST["copy"]){$J=copy_tables((array)$_POST["tables"],(array)$_POST["views"],$_POST["target"]);$D='Tables have been copied.';}elseif($_POST["drop"]){if($_POST["views"])$J=drop_views($_POST["views"]);if($J&&$_POST["tables"])$J=drop_tables($_POST["tables"]);$D='Tables have been dropped.';}elseif($y!="sql"){$J=($y=="sqlite"?queries("VACUUM"):apply_queries("VACUUM".($_POST["optimize"]?"":" ANALYZE"),$_POST["tables"]));$D='Tables have been optimized.';}elseif(!$_POST["tables"])$D='No tables.';elseif($J=queries(($_POST["optimize"]?"OPTIMIZE":($_POST["check"]?"CHECK":($_POST["repair"]?"REPAIR":"ANALYZE")))." TABLE ".implode(", ",array_map('idf_escape',$_POST["tables"])))){while($L=$J->fetch_assoc())$D.="<b>".h($L["Table"])."</b>: ".h($L["Msg_text"])."<br>";}queries_redirect(substr(ME,0,-1),$D,$J);}page_header(($_GET["ns"]==""?'Database'.": ".h(DB):'Schema'.": ".h($_GET["ns"])),$k,true);if($b->homepage()){if($_GET["ns"]!==""){echo"<h3 id='tables-views'>".'Tables and views'."</h3>\n";$pg=tables_list();if(!$pg)echo"<p class='message'>".'No tables.'."\n";else{echo"<form action='' method='post'>\n";if(support("table")){echo"<fieldset><legend>".'Search data in tables'." <span id='selected2'></span></legend><div>","<input type='search' name='query' value='".h($_POST["query"])."'>",script("qsl('input').onkeydown = partialArg(bodyKeydown, 'search');","")," <input type='submit' name='search' value='".'Search'."'>\n","</div></fieldset>\n";if($_POST["search"]&&$_POST["query"]!=""){$_GET["where"][0]["op"]="LIKE %%";search_tables();}}echo"<div class='scrollable'>\n","<table cellspacing='0' class='nowrap checkable'>\n",script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});"),'<thead><tr class="wrap">','<td><input id="check-all" type="checkbox" class="jsonly">'.script("qs('#check-all').onclick = partial(formCheck, /^(tables|views)\[/);",""),'<th>'.'Table','<td>'.'Engine'.doc_link(array('sql'=>'storage-engines.html')),'<td>'.'Collation'.doc_link(array('sql'=>'charset-charsets.html','mariadb'=>'supported-character-sets-and-collations/')),'<td>'.'Data Length'.doc_link(array('sql'=>'show-table-status.html',)),'<td>'.'Index Length'.doc_link(array('sql'=>'show-table-status.html',)),'<td>'.'Data Free'.doc_link(array('sql'=>'show-table-status.html')),'<td>'.'Auto Increment'.doc_link(array('sql'=>'example-auto-increment.html','mariadb'=>'auto_increment/')),'<td>'.'Rows'.doc_link(array('sql'=>'show-table-status.html',)),(support("comment")?'<td>'.'Comment'.doc_link(array('sql'=>'show-table-status.html',)):''),"</thead>\n";$S=0;foreach($pg
as$E=>$U){$mh=($U!==null&&!preg_match('~table~i',$U));$u=h("Table-".$E);echo'<tr'.odd().'><td>'.checkbox(($mh?"views[]":"tables[]"),$E,in_array($E,$qg,true),"","","",$u),'<th>'.(support("table")||support("indexes")?"<a href='".h(ME)."table=".urlencode($E)."' title='".'Show structure'."' id='$u'>".h($E).'</a>':h($E));if($mh){echo'<td colspan="6"><a href="'.h(ME)."view=".urlencode($E).'" title="'.'Alter view'.'">'.(preg_match('~materialized~i',$U)?'Materialized view':'View').'</a>','<td align="right"><a href="'.h(ME)."select=".urlencode($E).'" title="'.'Select data'.'">?</a>';}else{foreach(array("Engine"=>array(),"Collation"=>array(),"Data_length"=>array("create",'Alter table'),"Index_length"=>array("indexes",'Alter indexes'),"Data_free"=>array("edit",'New item'),"Auto_increment"=>array("auto_increment=1&create",'Alter table'),"Rows"=>array("select",'Select data'),)as$z=>$A){$u=" id='$z-".h($E)."'";echo($A?"<td align='right'>".(support("table")||$z=="Rows"||(support("indexes")&&$z!="Data_length")?"<a href='".h(ME."$A[0]=").urlencode($E)."'$u title='$A[1]'>?</a>":"<span$u>?</span>"):"<td id='$z-".h($E)."'>");}$S++;}echo(support("comment")?"<td id='Comment-".h($E)."'>":"");}echo"<tr><td><th>".sprintf('%d in total',count($pg)),"<td>".h($y=="sql"?$e->result("SELECT @@storage_engine"):""),"<td>".h(db_collation(DB,collations()));foreach(array("Data_length","Index_length","Data_free")as$z)echo"<td align='right' id='sum-$z'>";echo"</table>\n","</div>\n";if(!information_schema(DB)){echo"<div class='footer'><div>\n";$hh="<input type='submit' value='".'Vacuum'."'> ".on_help("'VACUUM'");$oe="<input type='submit' name='optimize' value='".'Optimize'."'> ".on_help($y=="sql"?"'OPTIMIZE TABLE'":"'VACUUM OPTIMIZE'");echo"<fieldset><legend>".'Selected'." <span id='selected'></span></legend><div>".($y=="sqlite"?$hh:($y=="pgsql"?$hh.$oe:($y=="sql"?"<input type='submit' value='".'Analyze'."'> ".on_help("'ANALYZE TABLE'").$oe."<input type='submit' name='check' value='".'Check'."'> ".on_help("'CHECK TABLE'")."<input type='submit' name='repair' value='".'Repair'."'> ".on_help("'REPAIR TABLE'"):"")))."<input type='submit' name='truncate' value='".'Truncate'."'> ".on_help($y=="sqlite"?"'DELETE'":"'TRUNCATE".($y=="pgsql"?"'":" TABLE'")).confirm()."<input type='submit' name='drop' value='".'Drop'."'>".on_help("'DROP TABLE'").confirm()."\n";$h=(support("scheme")?$b->schemas():$b->databases());if(count($h)!=1&&$y!="sqlite"){$i=(isset($_POST["target"])?$_POST["target"]:(support("scheme")?$_GET["ns"]:DB));echo"<p>".'Move to other database'.": ",($h?html_select("target",$h,$i):'<input name="target" value="'.h($i).'" autocapitalize="off">')," <input type='submit' name='move' value='".'Move'."'>",(support("copy")?" <input type='submit' name='copy' value='".'Copy'."'> ".checkbox("overwrite",1,$_POST["overwrite"],'overwrite'):""),"\n";}echo"<input type='hidden' name='all' value=''>";echo
script("qsl('input').onclick = function () { selectCount('selected', formChecked(this, /^(tables|views)\[/));".(support("table")?" selectCount('selected2', formChecked(this, /^tables\[/) || $S);":"")." }"),"<input type='hidden' name='token' value='$T'>\n","</div></fieldset>\n","</div></div>\n";}echo"</form>\n",script("tableCheck();");}echo'<p class="links"><a href="'.h(ME).'create=">'.'Create table'."</a>\n",(support("view")?'<a href="'.h(ME).'view=">'.'Create view'."</a>\n":"");if(support("routine")){echo"<h3 id='routines'>".'Routines'."</h3>\n";$zf=routines();if($zf){echo"<table cellspacing='0'>\n",'<thead><tr><th>'.'Name'.'<td>'.'Type'.'<td>'.'Return type'."<td></thead>\n";odd('');foreach($zf
as$L){$E=($L["SPECIFIC_NAME"]==$L["ROUTINE_NAME"]?"":"&name=".urlencode($L["ROUTINE_NAME"]));echo'<tr'.odd().'>','<th><a href="'.h(ME.($L["ROUTINE_TYPE"]!="PROCEDURE"?'callf=':'call=').urlencode($L["SPECIFIC_NAME"]).$E).'">'.h($L["ROUTINE_NAME"]).'</a>','<td>'.h($L["ROUTINE_TYPE"]),'<td>'.h($L["DTD_IDENTIFIER"]),'<td><a href="'.h(ME.($L["ROUTINE_TYPE"]!="PROCEDURE"?'function=':'procedure=').urlencode($L["SPECIFIC_NAME"]).$E).'">'.'Alter'."</a>";}echo"</table>\n";}echo'<p class="links">'.(support("procedure")?'<a href="'.h(ME).'procedure=">'.'Create procedure'.'</a>':'').'<a href="'.h(ME).'function=">'.'Create function'."</a>\n";}if(support("event")){echo"<h3 id='events'>".'Events'."</h3>\n";$M=get_rows("SHOW EVENTS");if($M){echo"<table cellspacing='0'>\n","<thead><tr><th>".'Name'."<td>".'Schedule'."<td>".'Start'."<td>".'End'."<td></thead>\n";foreach($M
as$L){echo"<tr>","<th>".h($L["Name"]),"<td>".($L["Execute at"]?'At given time'."<td>".$L["Execute at"]:'Every'." ".$L["Interval value"]." ".$L["Interval field"]."<td>$L[Starts]"),"<td>$L[Ends]",'<td><a href="'.h(ME).'event='.urlencode($L["Name"]).'">'.'Alter'.'</a>';}echo"</table>\n";$bc=$e->result("SELECT @@event_scheduler");if($bc&&$bc!="ON")echo"<p class='error'><code class='jush-sqlset'>event_scheduler</code>: ".h($bc)."\n";}echo'<p class="links"><a href="'.h(ME).'event=">'.'Create event'."</a>\n";}if($pg)echo
script("ajaxSetHtml('".js_escape(ME)."script=db');");}}}page_footer();