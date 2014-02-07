<?php
function cyrillic2latin($str){
	$converter = array(
		'а' => 'a',   'б' => 'b',   'в' => 'v',
		'г' => 'g',   'д' => 'd',   'е' => 'e',
		'ё' => 'yo',  'ж' => 'zh',  'з' => 'z',
		'и' => 'i',   'й' => 'y',   'к' => 'k',
		'л' => 'l',   'м' => 'm',   'н' => 'n',
		'о' => 'o',   'п' => 'p',   'р' => 'r',
		'с' => 's',   'т' => 't',   'у' => 'u',
		'ф' => 'f',   'х' => 'h',   'ц' => 'c',
		'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
		'ь' => '',    'ы' => 'y',   'ъ' => '',
		'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
 
		'А' => 'A',   'Б' => 'B',   'В' => 'V',
		'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
		'Ё' => 'Yo',  'Ж' => 'Zh',  'З' => 'Z',
		'И' => 'I',   'Й' => 'Y',   'К' => 'K',
		'Л' => 'L',   'М' => 'M',   'Н' => 'N',
		'О' => 'O',   'П' => 'P',   'Р' => 'R',
		'С' => 'S',   'Т' => 'T',   'У' => 'U',
		'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
		'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
		'Ь' => '',    'Ы' => 'Y',   'Ъ' => '',
		'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
		'№' => '',    ' ' => '-',
	);
	return strtr($str, $converter);
}

function drawVerticalMenu($db, $isAdmin=0){
	try{
		$query = $db->prepare("SELECT COUNT(*) FROM intcenter_pages WHERE isAdmin=? AND inVerticalMenu=1");
		$query->execute(array($isAdmin));
		$num = $query->fetch(PDO::FETCH_COLUMN);   

		$query = $db->prepare("SELECT link, name FROM intcenter_pages WHERE isAdmin=? AND inVerticalMenu=1");
		$query->execute(array($isAdmin));
		$pages = $query->fetchAll(PDO::FETCH_ASSOC);        
	}
	catch(PDOException $e){
		header('Location: /error/');
	}
	if(0 === $num){
		return false;
	}
	$admCSS = (1 === $isAdmin) ? $admStyle = ' v-adm-menu' : '';
	$page_link = !isset($_GET['page']) ? '' : $_GET['page'];
	echo "<div class='v-menu$admCSS'>",
	"\n\t\t\t", "<ul>";
		foreach ($pages as $page){
			($page['link'] === $page_link) ? $active = ' class="active"' : $active = '';
			echo "\n\t\t\t\t", "<li$active><a href='$page[link]'>$page[name]</a></li>";
		}
	echo "\n\t\t\t", "</ul>",
	"\n\t\t", "</div>\n";
	return true;
}

function drawHorizontalMenu(){
	echo "		<div class='h-menu'>
			<ul>
				<li>
					<a href='/learn-language/'><img src='../../../../img/foreign_lang.png' alt='Изучение иностранных языков'>
					Изучение иностранных&nbsp;языков</a>
				</li>
				<li>
					<a href='/visa-support/'><img src='../../../../img/visa_support.png' alt='Визовая поддержка'>Визовая поддержка</a>
				</li>
				<li>
					<a href='/summer-schools/'><img src='../../../../img/lang_schools.png' alt='Летние и зимние языковые школы'>Летние и зимние языковые школы</a>
				</li>
				<li>
					<a href='/prof-internships/'><img src='../../../../img/prof_internships.png' alt='Профессиональные стажеровки за рубежом'>Профессиональные стажировки за рубежом</a>
				</li>
				<li>
					<a href='/translate-documents/'><img src='../../../../img/doc_translate.png' alt='Перевод документов'>Перевод документов</a>
				</li>
			</ul>
		</div>";
	return true;
}

function drawProgramsMenu($db, $drawProgMenu = true){
	if(!$drawProgMenu){
		return false;
	}
	try{
		$query = $db->prepare("SELECT * FROM intcenter_prog_categories");
		$query->execute();
		$progCat = $query->fetchAll(PDO::FETCH_ASSOC);

		$query = $db->prepare("SELECT * FROM intcenter_programs");
		$query->execute();
		$progs = $query->fetchAll(PDO::FETCH_ASSOC);
	}
	catch(PDOException $e){
		header('Location: /error/');
	}
	echo "<div class='prog-menu'>
			<h3>Программы обучения</h3>
			<ul>";

	foreach($progCat as $pCat){
		$sql = "SELECT COUNT(*)
				FROM intcenter_prog_categories ipc
				LEFT JOIN intcenter_programs ip
				ON ipc.id=ip.cat_id
				WHERE ip.cat_id=?";
		try{
			$query = $db->prepare($sql);
			$query->execute(array($pCat['id']));
			$num = $query->fetchColumn();	
		}
		catch(PDOException $e){
			header('Location: /error/');
		}
		if($num > 0){
			echo "
				<li>
					<span>
						<span class='big'>$pCat[language]</span>
						<small>$pCat[category]</small>
						<img src='../../../../img/arrow_right.png' alt='Программы обучения'>
					</span>
					<ul>";
			$i = 0;
			foreach($progs as $prog){
				if($pCat['id'] === $prog['cat_id']){
					++$i;
					echo "
						<li>
							<a href='$prog[link]'>
								<span>$i</span>
								<small>$prog[category]</small>
								<b>$prog[name]</b>
							</a>
						</li>";
				}
			}
			echo"
					</ul>
				</li>";
		}
	}
	echo "
			</ul>
		</div>";
	return true;
}

function showNews($db){
	try{
		$query = $db->prepare("SELECT COUNT(*) FROM intcenter_news");
		$query->execute();
		$num = $query->fetchColumn();
	}
	catch(PDOException $e){
		header('Location: /error/');
	}
	if(0 === (int)$num){
		echo '<h3>Новости</h3>';
		echo "	Новостей нет
		</div>
		</div>
		";
		require_once 'block/bottom.php';
		require_once 'block/footer.php';
		exit;
	}
	try{
		$query = $db->prepare("SELECT * FROM intcenter_news ORDER BY date DESC");
		$query->execute();
		$row = $query->fetchAll(PDO::FETCH_ASSOC);
	}
	catch(PDOException $e){
		header('Location: /error/');
	}
	$page = !isset($_GET['page']) ? 0 : (int)str_replace('/', '', $_GET['page'])-1;
	$firstNews = $page*4+1;
	$news_counter = 0;
	echo '<h3>Новости</h3>';
	foreach ($row as $news) {
		++$news_counter;
		if($news_counter >= $firstNews and $news_counter <= $firstNews+3){
			echo "<div class='news'>
				<img src='$news[img]' alt='Изображение'>
				<div>
					<small>".date('d.m.Y', $news['date'])."</small>
					<a href='/news/$news[date]/'>$news[name]</a>
					<span>$news[annotation]</span>
				</div>
			</div>
			<hr>";
		}
	}
	return $num;
}

function pagination($resultCount, $contentNum, $page = ''){
	$maxShownPages = 6;
	$countPages = ($resultCount/$contentNum);
	if(is_float($countPages))
		$countPages = (int)$countPages+1;
	if('' !== $page)
		$page = '/'.$page;
	$active = !isset($_GET['page']) ? 1 : (int)str_replace('/', '', $_GET['page']);
	$prev = ($active <= 1) ? 1 : $active-1;
	$next = ($active >= $countPages) ? $countPages : $active+1;
	$shownPages = $countPages/2;

	if($countPages > 1){
		echo "
		<div class='pagination'>
			<ul>
				<li><a title='Предыдущая страница' href='$page/$prev/'>&larr;</a></li>\n\t\t\t\t";
		$style = '';
		if($countPages <= $maxShownPages){
			for ($i=1; $i <= $countPages; $i++, $style = '') {
				if($active === $i){
					$style = " class='active'";
				} 
				echo "<li><a$style href='$page/$i/'>$i</a></li>\n\t\t\t\t";
			}
		}
		else{
			if($active < $maxShownPages-1){
				for ($i=1; $i < $maxShownPages; $i++, $style = '') {
					if($active === $i){
						$style = " class='active'";
					} 
					echo "<li><a$style href='$page/$i/'>$i</a></li>\n\t\t\t\t";
				}				
			}
			else{
				echo "<li><a href='$page/1/'>1</a></li>\n\t\t\t\t";
				echo "<li> ... </li>\n\t\t\t\t";
				$endNum = $active >= $countPages ? $countPages+1 : $active+2;
				for ($i=$active-1; $i < $endNum ; $i++, $style='') { 
					if($active === $i)
						$style = " class='active'"; 
					echo "<li><a$style href='$page/$i/'>$i</a></li>\n\t\t\t\t";
				}
			}
			if($active < $countPages-1){
				if($active < $countPages-2){
					echo "<li> ... </li>\n\t\t\t\t";
				}
				echo "<li><a href='$page/$countPages/'>$countPages</a></li>\n\t\t\t\t";				
			}
		}
		echo "<li><a title='Следующая страница' href='$page/$next/'>&rarr;</a></li>
			</ul>
		</div>";
	}
	else{
		return false;
	}
	return true;
}

function breadcrumbs($db, $url){
	if(!isset($_GET['page'])){
		return false;
	}
	else{
		$page = $_GET['page'];
	}
	$var1 = !isset($_GET['var1']) ? '' : $_GET['var1'];
	$crumbs = explode('/', $url);
	$count = count($crumbs)-1;

	echo '<div class="breadcrumbs">';
	if('/news/' === $page){
		try{
			$query = $db->prepare("SELECT date FROM intcenter_news WHERE date=?");
			$query->execute(array($var1));
			$data = $query->fetch(PDO::FETCH_ASSOC);
		}
		catch(PDOException $e){
			header('Location: /error/');
		}
		echo '<a href="/">Главная</a> ';
		echo ' <span>&gt;</span> ';
		echo date('d.m.Y', $data['date']);
	}
	else{
		try{
			$query = $db->prepare("SELECT name FROM intcenter_pages WHERE link=?");
			$query->execute(array($page));
			$data = $query->fetch(PDO::FETCH_ASSOC);
		}
		catch(PDOException $e){
			header('Location: /error/');
		}
		for ($i=0; $i < $count; $i++) { 
			if(0 === $i){
				echo '<a href="/">Главная</a> ';
				echo ' <span>&gt;</span> ';
			}
			elseif($count-1 === $i){
				echo $data['name'];
			}
			else{
				echo "<a href='/$crumbs[$i]/'>$crumbs[$i]</a>";
				echo ' <span>&gt;</span> ';
			}
		}
	}
	echo '</div>';
}

function getPageName($db){
	$link = '';
	if(isset($_GET['page'])):
		$link = $_GET['page'];
	endif;
	try{
		$query = $db->prepare("SELECT name FROM intcenter_pages WHERE link=?");
		$query->execute(array($link));
		$row = $query->fetch(PDO::FETCH_ASSOC);
		$page = $row['name'];
		return $page;
	}
	catch(PDOException $e){
		header('Location: /error/');
	}
}

function getPageContent($db, $link){
	try{
		$query = $db->prepare("SELECT content FROM intcenter_pages WHERE link=?");
		$query->execute(array($link));
		$row = $query->fetch(PDO::FETCH_ASSOC);
		return $row['content'];
	}
	catch(PDOException $e){
		header('Location: /error/');
	}
}

// creates <select> with the required content
function select($db, $selected_type){
	$types = array(
				'page' => 'intcenter_pages',
				'news' => 'intcenter_news',
				'partner' => 'intcenter_partners',
				'service' => 'intcenter_services',
				'employee' => 'intcenter_employess'
				);
	foreach ($types as $key => $value) {
		if ($selected_type === $key) {
			$tbl = $value;
			break;
		}
		else{
			return false;
		}
	}
	if('intcenter_pages' === $tbl){
		$sql = "SELECT id, name FROM $tbl WHERE isAdmin = 0 AND isEditable = 1";
	}
	else{
		$sql = "SELECT id, name FROM $tbl";
	}
	try{
		$query = $db->prepare($sql);
		$query->execute();
		$row = $query->fetchAll(PDO::FETCH_ASSOC);
	}
	catch(PDOException $e){
		return false;
	}
	echo "<select name='".$selected_type."_name' id='selectContent'  data-type='$selected_type'>";
	echo"\n\t\t\t\t\t<option value=''> - - - - - - - не выбрано - - - - - - - </option>";
	foreach ($row as $option) {
		echo"\n\t\t\t\t\t<option value='$option[id]'>$option[name]</option>";
	}
	echo "\n\t\t\t\t</select>\n";
	return true;
}

/*##################################   BORROWED FUNCTIONS  ###############################*/

// Source link http://forum.php.su/topic.php?forum=35&topic=12&postid=1176547253#1176547253
function img_resize($src, $dest, $width, $height, $rgb=0xFFFFFF, $quality=100){
  if (!file_exists($src)) return false;
 
  $size = getimagesize($src);
 
  if ($size === false) return false;
 
  $format = strtolower(substr($size['mime'], strpos($size['mime'], '/')+1));
  $icfunc = "imagecreatefrom" . $format;
  if (!function_exists($icfunc)) return false;
 
  $x_ratio = $width / $size[0];
  $y_ratio = $height / $size[1];
 
  $ratio       = min($x_ratio, $y_ratio);
  $use_x_ratio = ($x_ratio == $ratio);
 
  $new_width   = $use_x_ratio  ? $width  : floor($size[0] * $ratio);
  $new_height  = !$use_x_ratio ? $height : floor($size[1] * $ratio);
  $new_left    = $use_x_ratio  ? 0 : floor(($width - $new_width) / 2);
  $new_top     = !$use_x_ratio ? 0 : floor(($height - $new_height) / 2);
 
  $isrc = $icfunc($src);
  $idest = imagecreatetruecolor($width, $height);
 
  imagefill($idest, 0, 0, $rgb);
  imagecopyresampled($idest, $isrc, $new_left, $new_top, 0, 0,
	$new_width, $new_height, $size[0], $size[1]);
 
  imagejpeg($idest, $dest, $quality);
 
  imagedestroy($isrc);
  imagedestroy($idest);
 
  return true;
}


/*##################################   NOT USED FUNCTIONS  ###############################*/
function getPagesList($db){
	try{
		$query = $db->prepare("SELECT page_id, name FROM tbl_pages WHERE admin=?");
		$query->execute(array(0));
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$row_pages = $query->fetchAll();
	}
	catch(PDOException $e){
		header('Location: /error/');
	}
	echo '<option value="" selected> - - - - - - - Не выбрано - - - - - - - </option>';
	foreach($row_pages as $page){
		echo "\n\t\t\t\t","<option value='$page[page_id]'>$page[name]</option>";
	}
	echo "\n";
}

function getSubpagesList($db){
	$sql = "SELECT sub_page_id, sp.name spn, p.name pn
			FROM tbl_sub_pages sp
			LEFT JOIN tbl_pages p
			ON sp.page_id=p.page_id
			WHERE sp.admin=?";
	try{
		$query = $db->prepare($sql);
		$query->execute(array(0));
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$row_sub_pages = $query->fetchAll();
	}
	catch(PDOException $e){
		header('Location: /error/');
	}
	echo '<option value="" selected> - - - - - - - Не выбрано - - - - - - - </option>';
	foreach($row_sub_pages as $sub_page){
		echo "\n\t\t\t\t","<option value='$sub_page[sub_page_id]'>{$sub_page['pn']} --> {$sub_page['spn']}</option>";
	}
	echo "\n";
}
?>