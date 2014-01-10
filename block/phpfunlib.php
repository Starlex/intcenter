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
		echo "Internal server error";
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

/* function for creating programs menu */
function drawProgramsMenu($db, $isAdmin=0){
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
		echo $e->getMessage();
	}
	echo "<div class='prog-menu'>";
	echo "
			<h3>Программы обучения</h3>";
	echo "
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
			echo $e->getMessage;
		}
		if($num > 0){
			echo "
					<li>
						<span>
							<span class='big'>$pCat[language]</span>
							<small>$pCat[category]</small>
							<img src='../img/arrow_right.png' alt='Программы обучения'>
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
				</ul>";
		}
		echo "</li>";
	}
	echo "</ul>
	</div>";
}

/* show news on main page */
function showNews($db){
	
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