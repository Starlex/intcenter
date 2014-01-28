<?php
/* show errors */
function showMsg($string, $link='', $text='Назад'){
	if('' !== $link){
		$anchor = "<a href='$link'>$text</a>";
	}
	else{
		$anchor = '';
	}
	?>
	<p>
		<b class='req'><?=$string?></b>
	</p>
	<?=$anchor?>
</div>
	<?php
	require_once 'block/bottom.php';
	require_once 'block/footer.php';
	exit;
}

/* Change cyrillic symbols to latin */
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

/* function for creating vertical menu */
function drawVerticalMenu($db, $isAdmin=0){
	try{
		$query = $db->prepare("SELECT link, name FROM intcenter_pages WHERE isAdmin=?");
		$query->execute(array($isAdmin));
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$pages = $query->fetchAll();        
	}
	catch(PDOException $e){
		echo "Error 500 - Internal server error";
		exit;
	}
	echo "<div class='v-menu'>",
	"\n\t\t\t", "<ul>";
		foreach ($pages as $page):
			echo "\n\t\t\t\t", "<li><a href='$page[link]'>$page[name]</a></li>";
		endforeach;
	echo "\n\t\t\t", "</ul>",
	"\n\t\t", "</div>\n";
}

function drawHorizontalMenu($dontDraw = false){
	if(true === $dontDraw){
		return false;
	}
	echo "		<div class='h-menu'>
			<ul>
				<li>
					<a href='learn-language/'><img src='../../../../img/foreign_lang.png' alt='Изучение иностранных языков'>
					Изучение иностранных&nbsp;языков</a>
				</li>
				<li>
					<a href='visa-support/'><img src='../../../../img/visa_support.png' alt='Визовая поддержка'>Визовая поддержка</a>
				</li>
				<li>
					<a href='summer-schools/'><img src='../../../../img/lang_schools.png' alt='Летние и зимние языковые школы'>Летние и зимние языковые школы</a>
				</li>
				<li>
					<a href='prof-internships/'><img src='../../../../img/prof_internships.png' alt='Профессиональные стажеровки за рубежом'>Профессиональные стажировки за рубежом</a>
				</li>
				<li>
					<a href='translate-documents/'><img src='../../../../img/doc_translate.png' alt='Перевод документов'>Перевод документов</a>
				</li>
			</ul>
		</div>";
	return true;
}

/* function for creating programs menu */
function drawProgramsMenu($db, $dontDraw=false){
	if(true === $dontDraw){
		return false;
	}
	try{
		$query = $db->prepare("SELECT * FROM intcenter_prog_categories");
		$query->execute();
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$progCat = $query->fetchAll();

		$query = $db->prepare("SELECT * FROM intcenter_programs");
		$query->execute();
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$progs = $query->fetchAll();
	}
	catch(PDOException $e){
		echo "Error 500 - Internal server error";
		exit;
	}
	echo "<div class='prog-menu'>
			<h3>Программы обучения</h3>
			<ul>";

	foreach($progCat as $pCat){
		$sql = "SELECT COUNT(*)
				FROM intcenter_prog_categories ipc
				LEFT JOIN intcenter_programs ip
				ON ipc.id=ip.cat_id
				WHERE $pCat[id]=ip.cat_id";
		try{
			$query = $db->prepare($sql);
			$query->execute();
			$num = $query->fetchColumn();	
		}
		catch(PDOException $e){
			echo "Error 500 - Internal server error";
			exit;
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
		echo "Error 500 - Internal server error";
		exit;
	}
	if(0 === $num){
		echo "	Новостей нет
		</div>";
		require_once 'block/bottom.php';
		require_once 'block/footer.php';
		exit;
	}
	try{
		$query = $db->prepare("SELECT * FROM intcenter_news");
		$query->execute();
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$row = $query->fetchAll();
	}
	catch(PDOException $e){
		echo "Error 500 - Internal server error";
		exit;
	}
	(!isset($_GET['page'])) ? $page = 0 : $page = (int)str_replace('/', '', $_GET['page'])-1;
	$firstNews = $page*4+1;
	echo '<h3>Новости</h3>';
	foreach ($row as $news) {
		if($news['id'] >= $firstNews and $news['id'] <= $firstNews+3){
			echo "<div class='news'>
				<img src='$news[img]' alt='Изображение'>
				<div>
					<small>".date('d.m.Y', $news['date'])."</small>
					<a href='/news/$news[id]/'>$news[name]</a>
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
	(!isset($_GET['page'])) ? $active = 1 : $active = (int)str_replace('/', '', $_GET['page']);
	($active <= 1) ? $prev = 1 : $prev = $active-1;
	($active >= $countPages) ? $next = $countPages : $next = $active+1;
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
				($active >= $countPages) ? $endNum = $countPages+1 : $endNum = $active+2;
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
}






/* Get page name and link from DB (NOT USED IN THIS PROJECT YET)*/
function getPageNameAndLink($db){
	$page = array('link' => '/glavnaya/', 'name' => '', 'tbl_name' => 'tbl_pages');
	if(isset($_GET['page'])):
		$page['link'] = $_GET['page'];
		$page['tbl_name'] = 'tbl_pages';
	endif;
	if(isset($_GET['var1'])):
		$page['link'] .= $_GET['var1'];
		$page['tbl_name'] = 'tbl_sub_pages';
		$page['link'] = substr($page['link'], strpos($page['link'], '/', 1)+1);
	endif;
	try{
		$query = $db->prepare("SELECT name FROM $page[tbl_name] WHERE link=?");
		$query->execute(array($page['link']));
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$row = $query->fetch();
		$page['name'] = $row['name'];
		return $page;
	}
	catch(PDOException $e){
		echo '<h1>Internal server error</h1>';
		exit;
	}
}

/* Get page content from DB (NOT USED IN THIS PROJECT YET)*/
function getPageContent($db, $pageData){
	try{
		$query = $db->prepare("SELECT page_content FROM $pageData[tbl_name] WHERE link=?");
		$query->execute(array($pageData['link']));
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$row = $query->fetch();
		return $row['page_content'];
	}
	catch(PDOException $e){
		echo '<h1>Internal server error</h1>';
		exit;
	}
}

/* get list of pages */
function getPagesList($db){
	try{
		$query = $db->prepare("SELECT page_id, name FROM tbl_pages WHERE admin=?");
		$query->execute(array(0));
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$row_pages = $query->fetchAll();
	}
	catch(PDOException $e){
		echo '<h1>Internal server error</h1>';
		exit;
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
		echo '<h1>Internal server error</h1>';
		exit;
	}
	echo '<option value="" selected> - - - - - - - Не выбрано - - - - - - - </option>';
	foreach($row_sub_pages as $sub_page){
		echo "\n\t\t\t\t","<option value='$sub_page[sub_page_id]'>{$sub_page['pn']} --> {$sub_page['spn']}</option>";
	}
	echo "\n";
}
?>