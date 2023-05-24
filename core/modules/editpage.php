<?php
/* 
	Appointment: Редактирование страницы
	File: editprofile.php 
 
*/
if(!defined('MOZG'))
	die('Hacking attempt!');

if($ajax == 'yes')
	NoAjaxQuery();

if($logged){
	$act = $_GET['act'];
	$pid = intval($_GET['pid']);
	$user_id = $user_info['user_id'];

	$row = $db->super_query("SELECT id, admin, title, descr, lastnews, ban_reason, traf, ulist, photo, date, data_del, feedback, comments, discussion, links_num, videos_num, real_admin, rec_num, del, ban, adres, audio_num, type_public, web, date_created, privacy, gtype FROM `".PREFIX."_communities` WHERE id = '{$pid}'");
	$a_row = $db->super_query("SELECT level FROM `".PREFIX."_communities_admins` WHERE user_id = '{$user_id}' and pid = '{$pid}'");
	
	if(stripos($row['real_admin'], "{$user_id}") !== false)
		$real_admin = true;
	else
		$real_admin = false;
	
		switch($act){
		
			case "edit":
			
				if(stripos($row['admin'], "u{$user_id}|") !== false){
				
					$metatags['title'] = 'Редактирование информации';
					
					$tpl->load_template('epage/edit.tpl');
					
					$explode_type = explode('-',$row['type_public']);
					$explode_created = explode('-',$row['date_created']);
					
					$tpl->set('{pid}', $pid);
					$tpl->set('{title}', stripslashes($row['title']));
					$tpl->set('{descr}', stripslashes($row['descr']));
					$tpl->set('{website}', stripslashes($row['web']));
					$tpl->set('{edit-descr}', myBrRn(stripslashes($row['descr'])));
					if(!$row['adres']) $row['adres'] = 'public'.$row['id'];
					$tpl->set('{adres}', $row['adres']);
					
					$privaces = xfieldsdataload($row['privacy']);
					
					if($row['comments']) $tpl->set('{settings-comments}', 'comments');
					else $tpl->set('{settings-comments}', 'none');
					if($privaces['p_audio']) $tpl->set('{settings-audio}', 'audio');
					else $tpl->set('{settings-audio}', 'none');
					if($privaces['p_videos']) $tpl->set('{settings-videos}', 'videos');
					else $tpl->set('{settings-videos}', 'none');
					if($privaces['p_contact']) $tpl->set('{settings-contact}', 'contact');
					else $tpl->set('{settings-contact}', 'none');
					if($privaces['p_lastnews']) $tpl->set('{settings-lastnews}', 'lastnews');
					else $tpl->set('{settings-lastnews}', 'none');
					if($privaces['p_links']) $tpl->set('{settings-links}', 'links');
					else $tpl->set('{settings-links}', 'none');
					if($privaces['p_albums']) $tpl->set('{settings-albums}', 'albums');
					else $tpl->set('{settings-albums}', 'none');
					
					if($privaces['p_lastnews'] == 1){
					$tpl->set('[p_lastnews]', '');
					$tpl->set('[/p_lastnews]', '');
					} else
					$tpl->set_block("'\\[p_lastnews\\](.*?)\\[/p_lastnews\\]'si","");
					
					if($row['real_admin'] == $user_id){
						$tpl->set('[admin-del]', '');
						$tpl->set('[/admin-del]', '');
					} else $tpl->set_block("'\\[admin-del\\](.*?)\\[/admin-del\\]'si","");		

					if($real_admin or $a_row['level'] == '3'){
					$tpl->set('[noadmin_red]', '');
					$tpl->set('[/noadmin_red]', '');
					} else
					$tpl->set_block("'\\[noadmin_red\\](.*?)\\[/noadmin_red\\]'si","");
					
					$sql_category = $db->super_query("SELECT id, name FROM `".PREFIX."_communities_category` WHERE type = '1'", 1);
			
					if($explode_type[1] != 0) $explode_type[0] = $explode_type[0]-1;
					if($explode_type[0] == 0) {$class_on = 'active';$name_cat = '- Не выбрано -';$id_cat = '0';}
			
					$category = InstallationSelectedNew($explode_type[0],'<li onmousemove="Select.itemMouseMove(1, 0)" val="0" class="">- Не выбрано -</li>');
					foreach($sql_category as $sql) {
						if($explode_type[0] == $sql['id']) {$class = 'active';$name_cat = $sql['name'];$id_cat = $sql['id'];}
						$category .= InstallationSelectedNew($explode_type[0],'<li onmousemove="Select.itemMouseMove(1, '.$sql['id'].')" val="'.$sql['id'].'" class="">'.$sql['name'].'</li>');
					}
					
					$psql_category = $db->super_query("SELECT id, name FROM `".PREFIX."_communities_category` WHERE type = '".($explode_type[0]+1)."'", 1);
			
					if($explode_type[1] == 0) {$pname_cat = '- Не выбрано -';$pid_cat = '0';}
			
					$pcategory = InstallationSelectedNew($explode_type[1],'<li onmousemove="Select.itemMouseMove(2, 0)" val="0" class="">- Не выбрано -</li>');
					foreach($psql_category as $psql) {
						if($explode_type[1] == $psql['id']) {$pname_cat = $psql['name'];$pid_cat = $psql['id'];}
						$pcategory .= InstallationSelectedNew($explode_type[1],'<li onmousemove="Select.itemMouseMove(2, '.$psql['id'].')" val="'.$psql['id'].'" class="">'.$psql['name'].'</li>');
					}
					
					$psql_categoryg = $db->super_query("SELECT name FROM `".PREFIX."_communities_category` WHERE id = '".($explode_type[1])."'");
					if($explode_type[1] == 0) $tpl->set('{pcategory_name}', '- Не выбрано -');
					else $tpl->set('{pcategory_name}', $psql_categoryg['name']);
					if($explode_created[2] == 0) $years = 'Год:';
					else $years = $explode_created[2];
					
					$tpl->set('{categores}', $category);
					$tpl->set('{category_id}', $id_cat);
					$tpl->set('{category_name}', $name_cat);
					$tpl->set('{pcategores}', $pcategory);
					$tpl->set('{pcategory_id}', $pid_cat);
					$tpl->set('{years_name}', $years);
					$tpl->set('{years_id}', $explode_created[2]);
					$tpl->set('{years}', InstallationSelectedNew($explode_created[2],'<li onmousemove="Select.itemMouseMove(3, 0)" val="0" class="">Год:</li><li onmousemove="Select.itemMouseMove(3, 2014)" val="2014" class="">2014</li><li onmousemove="Select.itemMouseMove(3, 2013)" val="2013" class="">2013</li><li onmousemove="Select.itemMouseMove(3, 2012)" val="2012" class="">2012</li><li onmousemove="Select.itemMouseMove(3, 2011)" val="2011" class="">2011</li><li onmousemove="Select.itemMouseMove(3, 2010)" val="2010" class="">2010</li><li onmousemove="Select.itemMouseMove(3, 2009)" val="2009" class="">2009</li><li onmousemove="Select.itemMouseMove(3, 2008)" val="2008" class="">2008</li><li onmousemove="Select.itemMouseMove(3, 2007)" val="2007" class="">2007</li><li onmousemove="Select.itemMouseMove(3, 2006)" val="2006" class="">2006</li><li onmousemove="Select.itemMouseMove(3, 2005)" val="2005" class="">2005</li><li onmousemove="Select.itemMouseMove(3, 2004)" val="2004" class="">2004</li><li onmousemove="Select.itemMouseMove(3, 2003)" val="2003" class="">2003</li><li onmousemove="Select.itemMouseMove(3, 2002)" val="2002" class="">2002</li><li onmousemove="Select.itemMouseMove(3, 2001)" val="2001" class="">2001</li><li onmousemove="Select.itemMouseMove(3, 2000)" val="2000" class="">2000</li><li onmousemove="Select.itemMouseMove(3, 1999)" val="1999" class="">1999</li><li onmousemove="Select.itemMouseMove(3, 1998)" val="1998" class="">1998</li><li onmousemove="Select.itemMouseMove(3, 1997)" val="1997" class="">1997</li><li onmousemove="Select.itemMouseMove(3, 1996)" val="1996" class="">1996</li><li onmousemove="Select.itemMouseMove(3, 1995)" val="1995" class="">1995</li><li onmousemove="Select.itemMouseMove(3, 1994)" val="1994" class="">1994</li><li onmousemove="Select.itemMouseMove(3, 1993)" val="1993" class="">1993</li><li onmousemove="Select.itemMouseMove(3, 1992)" val="1992" class="">1992</li><li onmousemove="Select.itemMouseMove(3, 1991)" val="1991" class="">1991</li><li onmousemove="Select.itemMouseMove(3, 1990)" val="1990" class="">1990</li><li onmousemove="Select.itemMouseMove(3, 1989)" val="1989" class="">1989</li><li onmousemove="Select.itemMouseMove(3, 1988)" val="1988" class="">1988</li><li onmousemove="Select.itemMouseMove(3, 1987)" val="1987" class="">1987</li><li onmousemove="Select.itemMouseMove(3, 1986)" val="1986" class="">1986</li><li onmousemove="Select.itemMouseMove(3, 1985)" val="1985" class="">1985</li><li onmousemove="Select.itemMouseMove(3, 1984)" val="1984" class="">1984</li><li onmousemove="Select.itemMouseMove(3, 1983)" val="1983" class="">1983</li><li onmousemove="Select.itemMouseMove(3, 1982)" val="1982" class="">1982</li><li onmousemove="Select.itemMouseMove(3, 1981)" val="1981" class="">1981</li><li onmousemove="Select.itemMouseMove(3, 1980)" val="1980" class="">1980</li><li onmousemove="Select.itemMouseMove(3, 1979)" val="1979" class="">1979</li><li onmousemove="Select.itemMouseMove(3, 1978)" val="1978" class="">1978</li><li onmousemove="Select.itemMouseMove(3, 1977)" val="1977" class="">1977</li><li onmousemove="Select.itemMouseMove(3, 1976)" val="1976" class="">1976</li><li onmousemove="Select.itemMouseMove(3, 1975)" val="1975" class="">1975</li><li onmousemove="Select.itemMouseMove(3, 1974)" val="1974" class="">1974</li><li onmousemove="Select.itemMouseMove(3, 1973)" val="1973" class="">1973</li><li onmousemove="Select.itemMouseMove(3, 1972)" val="1972" class="">1972</li><li onmousemove="Select.itemMouseMove(3, 1971)" val="1971" class="">1971</li><li onmousemove="Select.itemMouseMove(3, 1970)" val="1970" class="">1970</li><li onmousemove="Select.itemMouseMove(3, 1969)" val="1969" class="">1969</li><li onmousemove="Select.itemMouseMove(3, 1968)" val="1968" class="">1968</li><li onmousemove="Select.itemMouseMove(3, 1967)" val="1967" class="">1967</li><li onmousemove="Select.itemMouseMove(3, 1966)" val="1966" class="">1966</li><li onmousemove="Select.itemMouseMove(3, 1965)" val="1965" class="">1965</li><li onmousemove="Select.itemMouseMove(3, 1964)" val="1964" class="">1964</li><li onmousemove="Select.itemMouseMove(3, 1963)" val="1963" class="">1963</li><li onmousemove="Select.itemMouseMove(3, 1962)" val="1962" class="">1962</li><li onmousemove="Select.itemMouseMove(3, 1961)" val="1961" class="">1961</li><li onmousemove="Select.itemMouseMove(3, 1960)" val="1960" class="">1960</li><li onmousemove="Select.itemMouseMove(3, 1959)" val="1959" class="">1959</li><li onmousemove="Select.itemMouseMove(3, 1958)" val="1958" class="">1958</li><li onmousemove="Select.itemMouseMove(3, 1957)" val="1957" class="">1957</li><li onmousemove="Select.itemMouseMove(3, 1956)" val="1956" class="">1956</li><li onmousemove="Select.itemMouseMove(3, 1955)" val="1955" class="">1955</li><li onmousemove="Select.itemMouseMove(3, 1954)" val="1954" class="">1954</li><li onmousemove="Select.itemMouseMove(3, 1953)" val="1953" class="">1953</li><li onmousemove="Select.itemMouseMove(3, 1952)" val="1952" class="">1952</li><li onmousemove="Select.itemMouseMove(3, 1951)" val="1951" class="">1951</li><li onmousemove="Select.itemMouseMove(3, 1950)" val="1950" class="">1950</li><li onmousemove="Select.itemMouseMove(3, 1949)" val="1949" class="">1949</li><li onmousemove="Select.itemMouseMove(3, 1948)" val="1948" class="">1948</li><li onmousemove="Select.itemMouseMove(3, 1947)" val="1947" class="">1947</li><li onmousemove="Select.itemMouseMove(3, 1946)" val="1946" class="">1946</li><li onmousemove="Select.itemMouseMove(3, 1945)" val="1945" class="">1945</li><li onmousemove="Select.itemMouseMove(3, 1944)" val="1944" class="">1944</li><li onmousemove="Select.itemMouseMove(3, 1943)" val="1943" class="">1943</li><li onmousemove="Select.itemMouseMove(3, 1942)" val="1942" class="">1942</li><li onmousemove="Select.itemMouseMove(3, 1941)" val="1941" class="">1941</li><li onmousemove="Select.itemMouseMove(3, 1940)" val="1940" class="">1940</li><li onmousemove="Select.itemMouseMove(3, 1939)" val="1939" class="">1939</li><li onmousemove="Select.itemMouseMove(3, 1938)" val="1938" class="">1938</li><li onmousemove="Select.itemMouseMove(3, 1937)" val="1937" class="">1937</li><li onmousemove="Select.itemMouseMove(3, 1936)" val="1936" class="">1936</li><li onmousemove="Select.itemMouseMove(3, 1935)" val="1935" class="">1935</li><li onmousemove="Select.itemMouseMove(3, 1934)" val="1934" class="">1934</li><li onmousemove="Select.itemMouseMove(3, 1933)" val="1933" class="">1933</li><li onmousemove="Select.itemMouseMove(3, 1932)" val="1932" class="">1932</li><li onmousemove="Select.itemMouseMove(3, 1931)" val="1931" class="">1931</li><li onmousemove="Select.itemMouseMove(3, 1930)" val="1930" class="">1930</li><li onmousemove="Select.itemMouseMove(3, 1929)" val="1929" class="">1929</li><li onmousemove="Select.itemMouseMove(3, 1928)" val="1928" class="">1928</li><li onmousemove="Select.itemMouseMove(3, 1927)" val="1927" class="">1927</li><li onmousemove="Select.itemMouseMove(3, 1926)" val="1926" class="">1926</li><li onmousemove="Select.itemMouseMove(3, 1925)" val="1925" class="">1925</li><li onmousemove="Select.itemMouseMove(3, 1924)" val="1924" class="">1924</li><li onmousemove="Select.itemMouseMove(3, 1923)" val="1923" class="">1923</li><li onmousemove="Select.itemMouseMove(3, 1922)" val="1922" class="">1922</li><li onmousemove="Select.itemMouseMove(3, 1921)" val="1921" class="">1921</li><li onmousemove="Select.itemMouseMove(3, 1920)" val="1920" class="">1920</li><li onmousemove="Select.itemMouseMove(3, 1919)" val="1919" class="">1919</li><li onmousemove="Select.itemMouseMove(3, 1918)" val="1918" class="">1918</li><li onmousemove="Select.itemMouseMove(3, 1917)" val="1917" class="">1917</li><li onmousemove="Select.itemMouseMove(3, 1916)" val="1916" class="">1916</li><li onmousemove="Select.itemMouseMove(3, 1915)" val="1915" class="">1915</li><li onmousemove="Select.itemMouseMove(3, 1914)" val="1914" class="">1914</li><li onmousemove="Select.itemMouseMove(3, 1913)" val="1913" class="">1913</li><li onmousemove="Select.itemMouseMove(3, 1912)" val="1912" class="">1912</li><li onmousemove="Select.itemMouseMove(3, 1911)" val="1911" class="">1911</li><li onmousemove="Select.itemMouseMove(3, 1910)" val="1910" class="">1910</li><li onmousemove="Select.itemMouseMove(3, 1909)" val="1909" class="">1909</li><li onmousemove="Select.itemMouseMove(3, 1908)" val="1908" class="">1908</li><li onmousemove="Select.itemMouseMove(3, 1907)" val="1907" class="">1907</li><li onmousemove="Select.itemMouseMove(3, 1906)" val="1906" class="">1906</li><li onmousemove="Select.itemMouseMove(3, 1905)" val="1905" class="">1905</li><li onmousemove="Select.itemMouseMove(3, 1904)" val="1904" class="">1904</li><li onmousemove="Select.itemMouseMove(3, 1903)" val="1903" class="">1903</li><li onmousemove="Select.itemMouseMove(3, 1902)" val="1902" class="">1902</li><li onmousemove="Select.itemMouseMove(3, 1901)" val="1901" class="">1901</li><li onmousemove="Select.itemMouseMove(3, 1900)" val="1900" class="">1900</li><li onmousemove="Select.itemMouseMove(3, 1899)" val="1899" class="">1899</li><li onmousemove="Select.itemMouseMove(3, 1898)" val="1898" class="">1898</li><li onmousemove="Select.itemMouseMove(3, 1897)" val="1897" class="">1897</li><li onmousemove="Select.itemMouseMove(3, 1896)" val="1896" class="">1896</li><li onmousemove="Select.itemMouseMove(3, 1895)" val="1895" class="">1895</li><li onmousemove="Select.itemMouseMove(3, 1894)" val="1894" class="">1894</li><li onmousemove="Select.itemMouseMove(3, 1893)" val="1893" class="">1893</li><li onmousemove="Select.itemMouseMove(3, 1892)" val="1892" class="">1892</li><li onmousemove="Select.itemMouseMove(3, 1891)" val="1891" class="">1891</li><li onmousemove="Select.itemMouseMove(3, 1890)" val="1890" class="">1890</li><li onmousemove="Select.itemMouseMove(3, 1889)" val="1889" class="">1889</li><li onmousemove="Select.itemMouseMove(3, 1888)" val="1888" class="">1888</li><li onmousemove="Select.itemMouseMove(3, 1887)" val="1887" class="">1887</li><li onmousemove="Select.itemMouseMove(3, 1886)" val="1886" class="">1886</li><li onmousemove="Select.itemMouseMove(3, 1885)" val="1885" class="">1885</li><li onmousemove="Select.itemMouseMove(3, 1884)" val="1884" class="">1884</li><li onmousemove="Select.itemMouseMove(3, 1883)" val="1883" class="">1883</li><li onmousemove="Select.itemMouseMove(3, 1882)" val="1882" class="">1882</li><li onmousemove="Select.itemMouseMove(3, 1881)" val="1881" class="">1881</li><li onmousemove="Select.itemMouseMove(3, 1880)" val="1880" class="">1880</li><li onmousemove="Select.itemMouseMove(3, 1879)" val="1879" class="">1879</li><li onmousemove="Select.itemMouseMove(3, 1878)" val="1878" class="">1878</li><li onmousemove="Select.itemMouseMove(3, 1877)" val="1877" class="">1877</li><li onmousemove="Select.itemMouseMove(3, 1876)" val="1876" class="">1876</li><li onmousemove="Select.itemMouseMove(3, 1875)" val="1875" class="">1875</li><li onmousemove="Select.itemMouseMove(3, 1874)" val="1874" class="">1874</li><li onmousemove="Select.itemMouseMove(3, 1873)" val="1873" class="">1873</li><li onmousemove="Select.itemMouseMove(3, 1872)" val="1872" class="">1872</li><li onmousemove="Select.itemMouseMove(3, 1871)" val="1871" class="">1871</li><li onmousemove="Select.itemMouseMove(3, 1870)" val="1870" class="">1870</li><li onmousemove="Select.itemMouseMove(3, 1869)" val="1869" class="">1869</li><li onmousemove="Select.itemMouseMove(3, 1868)" val="1868" class="">1868</li><li onmousemove="Select.itemMouseMove(3, 1867)" val="1867" class="">1867</li><li onmousemove="Select.itemMouseMove(3, 1866)" val="1866" class="">1866</li><li onmousemove="Select.itemMouseMove(3, 1865)" val="1865" class="">1865</li><li onmousemove="Select.itemMouseMove(3, 1864)" val="1864" class="">1864</li><li onmousemove="Select.itemMouseMove(3, 1863)" val="1863" class="">1863</li><li onmousemove="Select.itemMouseMove(3, 1862)" val="1862" class="">1862</li><li onmousemove="Select.itemMouseMove(3, 1861)" val="1861" class="">1861</li><li onmousemove="Select.itemMouseMove(3, 1860)" val="1860" class="">1860</li><li onmousemove="Select.itemMouseMove(3, 1859)" val="1859" class="">1859</li><li onmousemove="Select.itemMouseMove(3, 1858)" val="1858" class="">1858</li><li onmousemove="Select.itemMouseMove(3, 1857)" val="1857" class="">1857</li><li onmousemove="Select.itemMouseMove(3, 1856)" val="1856" class="">1856</li><li onmousemove="Select.itemMouseMove(3, 1855)" val="1855" class="">1855</li><li onmousemove="Select.itemMouseMove(3, 1854)" val="1854" class="">1854</li><li onmousemove="Select.itemMouseMove(3, 1853)" val="1853" class="">1853</li><li onmousemove="Select.itemMouseMove(3, 1852)" val="1852" class="">1852</li><li onmousemove="Select.itemMouseMove(3, 1851)" val="1851" class="">1851</li><li onmousemove="Select.itemMouseMove(3, 1850)" val="1850" class="">1850</li><li onmousemove="Select.itemMouseMove(3, 1849)" val="1849" class="">1849</li><li onmousemove="Select.itemMouseMove(3, 1848)" val="1848" class="">1848</li><li onmousemove="Select.itemMouseMove(3, 1847)" val="1847" class="">1847</li><li onmousemove="Select.itemMouseMove(3, 1846)" val="1846" class="">1846</li><li onmousemove="Select.itemMouseMove(3, 1845)" val="1845" class="">1845</li><li onmousemove="Select.itemMouseMove(3, 1844)" val="1844" class="">1844</li><li onmousemove="Select.itemMouseMove(3, 1843)" val="1843" class="">1843</li><li onmousemove="Select.itemMouseMove(3, 1842)" val="1842" class="">1842</li><li onmousemove="Select.itemMouseMove(3, 1841)" val="1841" class="">1841</li><li onmousemove="Select.itemMouseMove(3, 1840)" val="1840" class="">1840</li><li onmousemove="Select.itemMouseMove(3, 1839)" val="1839" class="">1839</li><li onmousemove="Select.itemMouseMove(3, 1838)" val="1838" class="">1838</li><li onmousemove="Select.itemMouseMove(3, 1837)" val="1837" class="">1837</li><li onmousemove="Select.itemMouseMove(3, 1836)" val="1836" class="">1836</li><li onmousemove="Select.itemMouseMove(3, 1835)" val="1835" class="">1835</li><li onmousemove="Select.itemMouseMove(3, 1834)" val="1834" class="">1834</li><li onmousemove="Select.itemMouseMove(3, 1833)" val="1833" class="">1833</li><li onmousemove="Select.itemMouseMove(3, 1832)" val="1832" class="">1832</li><li onmousemove="Select.itemMouseMove(3, 1831)" val="1831" class="">1831</li><li onmousemove="Select.itemMouseMove(3, 1830)" val="1830" class="">1830</li><li onmousemove="Select.itemMouseMove(3, 1829)" val="1829" class="">1829</li><li onmousemove="Select.itemMouseMove(3, 1828)" val="1828" class="">1828</li><li onmousemove="Select.itemMouseMove(3, 1827)" val="1827" class="">1827</li><li onmousemove="Select.itemMouseMove(3, 1826)" val="1826" class="">1826</li><li onmousemove="Select.itemMouseMove(3, 1825)" val="1825" class="">1825</li><li onmousemove="Select.itemMouseMove(3, 1824)" val="1824" class="">1824</li><li onmousemove="Select.itemMouseMove(3, 1823)" val="1823" class="">1823</li><li onmousemove="Select.itemMouseMove(3, 1822)" val="1822" class="">1822</li><li onmousemove="Select.itemMouseMove(3, 1821)" val="1821" class="">1821</li><li onmousemove="Select.itemMouseMove(3, 1820)" val="1820" class="">1820</li><li onmousemove="Select.itemMouseMove(3, 1819)" val="1819" class="">1819</li><li onmousemove="Select.itemMouseMove(3, 1818)" val="1818" class="">1818</li><li onmousemove="Select.itemMouseMove(3, 1817)" val="1817" class="">1817</li><li onmousemove="Select.itemMouseMove(3, 1816)" val="1816" class="">1816</li><li onmousemove="Select.itemMouseMove(3, 1815)" val="1815" class="">1815</li><li onmousemove="Select.itemMouseMove(3, 1814)" val="1814" class="">1814</li><li onmousemove="Select.itemMouseMove(3, 1813)" val="1813" class="">1813</li><li onmousemove="Select.itemMouseMove(3, 1812)" val="1812" class="">1812</li><li onmousemove="Select.itemMouseMove(3, 1811)" val="1811" class="">1811</li><li onmousemove="Select.itemMouseMove(3, 1810)" val="1810" class="">1810</li><li onmousemove="Select.itemMouseMove(3, 1809)" val="1809" class="">1809</li><li onmousemove="Select.itemMouseMove(3, 1808)" val="1808" class="">1808</li><li onmousemove="Select.itemMouseMove(3, 1807)" val="1807" class="">1807</li><li onmousemove="Select.itemMouseMove(3, 1806)" val="1806" class="">1806</li><li onmousemove="Select.itemMouseMove(3, 1805)" val="1805" class="">1805</li><li onmousemove="Select.itemMouseMove(3, 1804)" val="1804" class="">1804</li><li onmousemove="Select.itemMouseMove(3, 1803)" val="1803" class="">1803</li><li onmousemove="Select.itemMouseMove(3, 1802)" val="1802" class="">1802</li><li onmousemove="Select.itemMouseMove(3, 1801)" val="1801" class="">1801</li><li onmousemove="Select.itemMouseMove(3, 1800)" val="1800" class="">1800</li>'));
					$tpl->set('{month_id}', $explode_created[1]);
					$tpl->set('{month_name}', convertMonth($explode_created[1]));
					$tpl->set('{month}', InstallationSelectedNew($explode_created[1],'<li onmousemove="Select.itemMouseMove(4, 0)" val="0" class="">Месяц:</li><li onmousemove="Select.itemMouseMove(4, 1)" val="1" class="">Января</li><li onmousemove="Select.itemMouseMove(4, 2)" val="2" class="">Февраля</li><li onmousemove="Select.itemMouseMove(4, 3)" val="3" class="">Марта</li><li onmousemove="Select.itemMouseMove(4, 4)" val="4" class="">Апреля</li><li onmousemove="Select.itemMouseMove(4, 5)" val="5" class="">Мая</li><li onmousemove="Select.itemMouseMove(4, 6)" val="6" class="">Июня</li><li onmousemove="Select.itemMouseMove(4, 7)" val="7" class="">Июля</li><li onmousemove="Select.itemMouseMove(4, 8)" val="8" class="">Августа</li><li onmousemove="Select.itemMouseMove(4, 9)" val="9" class="">Сентября</li><li onmousemove="Select.itemMouseMove(4, 10)" val="10" class="">Отктября</li><li onmousemove="Select.itemMouseMove(4, 11)" val="11" class="">Ноября</li><li onmousemove="Select.itemMouseMove(4, 12)" val="12" class="">Декабря</li>'));
				
					$dmonth = monthdays($type,date('Y'));
					if($dmonth>28) $h = '<li onmousemove="Select.itemMouseMove(5, 29)" val="29" class="">29</li>';
					if($dmonth>29) $h.= '<li onmousemove="Select.itemMouseMove(5, 30)" val="30" class="">30</li>';
					if($dmonth>30) $h.= '<li onmousemove="Select.itemMouseMove(5, 31)" val="31" class="">31</li>';

					if($explode_created[0] == 0) $days = 'День:';
					else $days = $explode_created[0];
					
					$tpl->set('{day_name}', $days);
					$tpl->set('{day_id}', $explode_created[0]);
					$tpl->set('{day}', InstallationSelectedNew($explode_created[0],'<li onmousemove="Select.itemMouseMove(5, 0)"  val="0" class="">День:</li><li onmousemove="Select.itemMouseMove(5, 1)" val="1" class="">1</li><li onmousemove="Select.itemMouseMove(5, 2)" val="2" class="">2</li><li onmousemove="Select.itemMouseMove(5, 3)" val="3" class="">3</li><li onmousemove="Select.itemMouseMove(5, 4)" val="4" class="">4</li><li onmousemove="Select.itemMouseMove(5, 5)" val="5" class="">5</li><li onmousemove="Select.itemMouseMove(5, 6)" val="6" class="">6</li><li onmousemove="Select.itemMouseMove(5, 7)" val="7" class="">7</li><li onmousemove="Select.itemMouseMove(5, 8)" val="8" class="">8</li><li onmousemove="Select.itemMouseMove(5, 9)" val="9" class="">9</li><li onmousemove="Select.itemMouseMove(5, 10)" val="10" class="">10</li><li onmousemove="Select.itemMouseMove(5, 11)" val="11" class="">11</li><li onmousemove="Select.itemMouseMove(5, 12)" val="12" class="">12</li><li onmousemove="Select.itemMouseMove(5, 13)" val="13" class="">13</li><li onmousemove="Select.itemMouseMove(5, 14)" val="14" class="">14</li><li onmousemove="Select.itemMouseMove(5, 15)" val="15" class="">15</li><li onmousemove="Select.itemMouseMove(5, 16)" val="16" class="">16</li><li onmousemove="Select.itemMouseMove(5, 17)" val="17" class="">17</li><li onmousemove="Select.itemMouseMove(5, 18)" val="18" class="">18</li><li onmousemove="Select.itemMouseMove(5, 19)" val="19" class="">19</li><li onmousemove="Select.itemMouseMove(5, 20)" val="20" class="">20</li><li onmousemove="Select.itemMouseMove(5, 21)" val="21" class="">21</li><li onmousemove="Select.itemMouseMove(5, 22)" val="22" class="">22</li><li onmousemove="Select.itemMouseMove(5, 23)" val="23" class="">23</li><li onmousemove="Select.itemMouseMove(5, 24)" val="24" class="">24</li><li onmousemove="Select.itemMouseMove(5, 25)" val="25" class="">25</li><li onmousemove="Select.itemMouseMove(5, 26)" val="26" class="">26</li><li onmousemove="Select.itemMouseMove(5, 27)" val="27" class="">27</li><li onmousemove="Select.itemMouseMove(5, 28)" val="28" class="">28</li>'.$h));
					
					$tpl->compile('content');
				
				} else {
					$user_speedbar = 'Информация';
					msgbox('', '<div style="margin:0 auto; width:370px;text-align:center;height:65px;font-weight:bold">Вы не имеете прав для редактирования данного сообщества.<br><br><div class="button_blue fl_l" style="margin-left:115px;"><a href="/public'.$pid.'" onClick="Page.Go(this.href); return false"><button>На страницу сообщества</button></a></div></div>', 'info_red');
				}
				
			break;
			
			case "swtichList":
				NoAjaxQuery();
				
				$type = intval($_POST['type']+1);
				
				$psql_category = $db->super_query("SELECT id, name FROM `".PREFIX."_communities_category` WHERE type = '{$type}'", 1);
		
				$explode_type = explode('-',$row['type_public']);
				if($explode_type[1] == 0) {$pclass_on = 'active';}
				else $pclass_on='';
		
				$pcategory = '<li onmousemove="Select.itemMouseMove(2, 0)" val="0" class="'.$pclass_on.' first">- Не выбрано -</li>';
				foreach($psql_category as $psql) {
					$pcategory .= InstallationSelectedNew($explode_created[1],'<li onmousemove="Select.itemMouseMove(2, '.$psql['id'].')" val="'.$psql['id'].'" class="">'.$psql['name'].'</li>');
				}
				
				echo $pcategory;
				
				die();
			break;
			
			case "swtichListMonth":
				NoAjaxQuery();
				
				$type = intval($_POST['type']);
				if($type<=0 and $type>12) $type = 1;
				
				$dmonth = monthdays($type,date('Y'));
				
				if($dmonth>28) $h = '<li onmousemove="Select.itemMouseMove(5, 29)" val="29" class="">29</li>';
				if($dmonth>29) $h.= '<li onmousemove="Select.itemMouseMove(5, 30)" val="30" class="">30</li>';
				if($dmonth>30) $h.= '<li onmousemove="Select.itemMouseMove(5, 31)" val="31" class="">31</li>';

				$temp = '<li onmousemove="Select.itemMouseMove(5, 0)"  val="0" class="active">День:</li><li onmousemove="Select.itemMouseMove(5, 1)" val="1" class="">1</li><li onmousemove="Select.itemMouseMove(5, 2)" val="2" class="">2</li><li onmousemove="Select.itemMouseMove(5, 3)" val="3" class="">3</li><li onmousemove="Select.itemMouseMove(5, 4)" val="4" class="">4</li><li onmousemove="Select.itemMouseMove(5, 5)" val="5" class="">5</li><li onmousemove="Select.itemMouseMove(5, 6)" val="6" class="">6</li><li onmousemove="Select.itemMouseMove(5, 7)" val="7" class="">7</li><li onmousemove="Select.itemMouseMove(5, 8)" val="8" class="">8</li><li onmousemove="Select.itemMouseMove(5, 9)" val="9" class="">9</li><li onmousemove="Select.itemMouseMove(5, 10)" val="10" class="">10</li><li onmousemove="Select.itemMouseMove(5, 11)" val="11" class="">11</li><li onmousemove="Select.itemMouseMove(5, 12)" val="12" class="">12</li><li onmousemove="Select.itemMouseMove(5, 13)" val="13" class="">13</li><li onmousemove="Select.itemMouseMove(5, 14)" val="14" class="">14</li><li onmousemove="Select.itemMouseMove(5, 15)" val="15" class="">15</li><li onmousemove="Select.itemMouseMove(5, 16)" val="16" class="">16</li><li onmousemove="Select.itemMouseMove(5, 17)" val="17" class="">17</li><li onmousemove="Select.itemMouseMove(5, 18)" val="18" class="">18</li><li onmousemove="Select.itemMouseMove(5, 19)" val="19" class="">19</li><li onmousemove="Select.itemMouseMove(5, 20)" val="20" class="">20</li><li onmousemove="Select.itemMouseMove(5, 21)" val="21" class="">21</li><li onmousemove="Select.itemMouseMove(5, 22)" val="22" class="">22</li><li onmousemove="Select.itemMouseMove(5, 23)" val="23" class="">23</li><li onmousemove="Select.itemMouseMove(5, 24)" val="24" class="">24</li><li onmousemove="Select.itemMouseMove(5, 25)" val="25" class="">25</li><li onmousemove="Select.itemMouseMove(5, 26)" val="26" class="">26</li><li onmousemove="Select.itemMouseMove(5, 27)" val="27" class="">27</li><li onmousemove="Select.itemMouseMove(5, 28)" val="28" class="">28</li>'.$h;
				
				echo $temp;
				
				die();
			break;
			
			case "saveGeneralInfo":
				NoAjaxQuery();
				$id = intval($_POST['id']);
				$title = ajax_utf8(textFilter($_POST['title'], false, true));
				$adres_page = ajax_utf8(strtolower(textFilter($_POST['adres'], false, true)));
				$descr = ajax_utf8(textFilter($_POST['descr'], 5000));
				$website = ajax_utf8(textFilter($_POST['website'], false, true));
				$comments = intval($_POST['comments']);
				$audio = intval($_POST['audio']);
				$contact = intval($_POST['contact']);
				$videos = intval($_POST['videos']);
				$links = intval($_POST['links']);
				$lastnews = intval($_POST['lastnews']);
				$albums = intval($_POST['albums']);
				$day = intval($_POST['day']);
				$month = intval($_POST['month']);
				$years = intval($_POST['years']);
				$category = intval($_POST['category']);
				$pcategory = intval($_POST['pcategory']);
				
				if($day<0 or $day>31) $day = 0;
				if($month<0 or $month>12) $month = 0;
				if($years<1800 or $years>date('Y')) $years = 0;
				if($category<0 or $category>12) $category = 0;
				if($pcategory<0 or $pcategory>87) $pcategory = 0;
				if($comments<0 or $comments>1) $comments = 0;
				if($audio<0 or $audio>1) $audio = 0;
				if($contact<0 or $contact>1) $contact = 0;
				if($videos<0 or $videos>1) $videos = 0;
				if($links<0 or $links>1) $links = 0;
				if($albums<0 or $albums>1) $albums = 0;
				
				if($category and $pcategory) {
					$check_pcategory = $db->super_query("SELECT type FROM `".PREFIX."_communities_category` WHERE id = '".$pcategory."'");
					if($check_pcategory) $category = $check_pcategory['type'];
					else $category = 0;
				}
				
				$privacy = "p_audio|{$audio}||p_contact|{$contact}||p_videos|{$videos}||p_links|{$links}||p_lastnews|{$lastnews}||p_albums|{$albums}||";
				$type_public = $category.'-'.$pcategory;
				$date_created = $day.'-'.$month.'-'.$years;
				
				$gtypenew = gtypeNew($category);
				
				if(!preg_match("/^[a-zA-Z0-9_-]+$/", $adres_page)) $adress_ok = false;
				else $adress_ok = true;

				//Проверка на то, что действиие делает админ
				$checkAdmin = $db->super_query("SELECT admin FROM `".PREFIX."_communities` WHERE id = '".$id."'");

				if(stripos($checkAdmin['admin'], "u{$user_id}|") !== false AND isset($title) AND !empty($title) AND $adress_ok){
					if(preg_match('/public[0-9]/i', $adres_page))
						$adres_page = '';

					//Проверка на то, что адрес страницы свободен
					if($adres_page)
						$checkAdres = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_communities` WHERE adres = '".$adres_page."' AND id != '".$id."'");
						$checkAdresClubs = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_clubs` WHERE adres = '".$adres_page."'");
						$chek_user = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_users` WHERE alias = '".$adres_page."' "); // Проверяем адреса у пользователей
					if(!$checkAdres['cnt'] AND !$chek_user['cnt'] AND !$checkAdresClubs['cnt'] OR $adres_page == ''){
						$db->query("UPDATE `".PREFIX."_communities` SET title = '".$title."', descr = '".$descr."', comments = '".$comments."', adres = '".$adres_page."', web = '".$website."', date_created = '".$date_created."', type_public = '".$type_public."', privacy = '".$privacy."', gtype = '".$gtypenew."' WHERE id = '".$id."'");
						if(!$adres_page)
							echo 'no_new';
					} else
						echo 'err_adres';

					mozg_clear_cache_folder('groups');
				}
				
				die();
			break;
			
			case "lastnews":
			
				if($real_admin or $a_row['level'] == '3'){
				
					$metatags['title'] = 'Редактирование информации';
					
					$tpl->load_template('epage/lastnews.tpl');
					
					$explode_type = explode('-',$row['type_public']);
					$explode_created = explode('-',$row['date_created']);
					
					$tpl->set('{pid}', $pid);
					//Подключаем парсер
					include ENGINE_DIR.'/classes/parse.php';
					$parse = new parse();
					$tpl->set('{lastnews}', $parse->BBdecode(stripslashes(myBrRn($row['lastnews']))));
					if(!$row['adres']) $row['adres'] = 'public'.$row['id'];
					$tpl->set('{adres}', $row['adres']);
					$tpl->set('{gtype}', installationSelected($row['gtype'], '<option value="СМИ">СМИ</option><option value="Электроника и техника">Электроника и техника</option><option value="Фото, оптика">Фото, оптика</option><option value="Услуги и деятельность">Услуги и деятельность</option><option value="Телефоны и связь">Телефоны и связь</option><option value="Строительство и ремонт">Строительство и ремонт</option><option value="Публичная страница">Публичная страница</option><option value="Отказаться от рекламы">Отказаться от рекламы</option><option value="Одежда, обувь, аксессуары">Одежда, обувь, аксессуары</option><option value="Недвижимость">Недвижимость</option><option value="Музыка, искусство">Музыка, искусство</option><option value="Мебель, интерьер">Мебель, интерьер</option><option value="Компьютерная техника">Компьютерная техника</option><option value="Книги, учебники, журналы">Книги, учебники, журналы</option><option value="Игры">Игры</option><option value="Видео">Видео</option><option value="Авто и мото">Авто и мото</option> '));  

					
					$privaces = xfieldsdataload($row['privacy']);
					
					if($row['comments']) $tpl->set('{settings-comments}', 'comments');
					else $tpl->set('{settings-comments}', 'none');
					if($privaces['p_audio']) $tpl->set('{settings-audio}', 'audio');
					else $tpl->set('{settings-audio}', 'none');
					if($privaces['p_videos']) $tpl->set('{settings-videos}', 'videos');
					else $tpl->set('{settings-videos}', 'none');
					if($privaces['p_contact']) $tpl->set('{settings-contact}', 'contact');
					else $tpl->set('{settings-contact}', 'none');
					if($privaces['p_lastnews']) $tpl->set('{settings-lastnews}', 'lastnews');
					else $tpl->set('{settings-lastnews}', 'none');
					
					if($privaces['p_lastnews'] == 1){
					$tpl->set('[p_lastnews]', '');
					$tpl->set('[/p_lastnews]', '');
					} else
					$tpl->set_block("'\\[p_lastnews\\](.*?)\\[/p_lastnews\\]'si","");
					
					if($row['real_admin'] == $user_id){
						$tpl->set('[admin-del]', '');
						$tpl->set('[/admin-del]', '');
					} else $tpl->set_block("'\\[admin-del\\](.*?)\\[/admin-del\\]'si","");
					
					$tpl->compile('content');
				
				} else {
					$user_speedbar = 'Информация';
					msgbox('', '<div style="margin:0 auto; width:370px;text-align:center;height:65px;font-weight:bold">Вы не имеете прав для редактирования данного сообщества.<br><br><div class="button_blue fl_l" style="margin-left:115px;"><a href="/public'.$pid.'" onClick="Page.Go(this.href); return false"><button>На страницу сообщества</button></a></div></div>', 'info_red');
				}
				
			break;
			
			case "saveNews":
				NoAjaxQuery();
				$id = intval($_POST['id']);
				//Подключаем парсер
				include ENGINE_DIR.'/classes/parse.php';
				$parse = new parse();
				$lastnews = $parse->BBparse(ajax_utf8(textFilter($_POST['lastnews'])));

				//Проверка на то, что действиие делает админ
				$checkAdmin = $db->super_query("SELECT admin FROM `".PREFIX."_communities` WHERE id = '".$id."'");

				if(stripos($checkAdmin['admin'], "u{$user_id}|") !== false){
					if(preg_match('/public[0-9]/i', $adres_page))
						$adres_page = '';

						$db->query("UPDATE `".PREFIX."_communities` SET lastnews = '".$lastnews."' WHERE id = '".$id."'");

					mozg_clear_cache_folder('groups');
				}
				
				die();
			break;
			
			case "blacklist":

				if(stripos($row['admin'], "u{$user_id}|") !== false) {
				
					$cnt_pages = intval($_POST['page_cnt']);
					if(!$_POST['page_cnt']) $page_cnt = 25;
					else $page_cnt = $cnt_pages*25;
					
					$metatags['title'] = 'Участники';
					$tpl->load_template('epage/blacklist.tpl');
					$tpl->set('{pid}', $pid);
					if(!$row['adres']) $tpl->set('{adres}', 'public'.$row['id']);
					else $tpl->set('{adres}', $row['adres']);
					
					$blacklist = $db->super_query("SELECT COUNT(*) as cnt FROM `".PREFIX."_communities_blacklist` WHERE pid = '{$pid}'");
					
					if(!$blacklist['cnt']) {
						$tpl->set('{title}', 'Нет ни одного заблокированного пользователя');
						$tpl->set('[no_banned]','');
						$tpl->set('[/no_banned]','');
					} else {
						$tpl->set('{title}', 'В сообществе '.$blacklist['cnt'].' '.gram_record($blacklist['cnt'], 'blocked').' '.gram_record($blacklist['cnt'], 'blocked_users').'');
						$tpl->set_block("'\\[no_banned\\](.*?)\\[/no_banned\\]'si","");
					}
					$tpl->compile('content');
					
					$blacklistSQL = $db->super_query("SELECT tb1.user_id, admin, date, tb2.user_search_pref, alias, user_photo FROM `".PREFIX."_communities_blacklist` tb1, `".PREFIX."_users` tb2 WHERE tb2.user_id = tb1.user_id and pid = '{$pid}'",1);
					
					$tpl->result['content'] .= '<div id="group_bl_rows">';
					foreach($blacklistSQL as $row_) {
						$aSQL = $db->super_query("SELECT user_search_pref FROM `".PREFIX."_users` WHERE user_id = '{$row_['admin']}'");
						$tpl->load_template('epage/blackuser.tpl');
						if($row_['alias']) $alias = $row_['alias'];
						else $alias = 'id'.$row_['user_id'];
						$tpl->set('{alias}', $alias);
						if($row_['user_photo']) $avatar = '/uploads/users/'.$row_['user_id'].'/50_'.$row_['user_photo'];
						else $avatar = '/templates/Default/images/no_ava_50.png';
						$tpl->set('{ava}', $avatar);
						$tpl->set('{name}', $row_['user_search_pref']);
						$tpl->set('{nadmin}', $aSQL['user_search_pref']);
						$tpl->set('{date}', megaDateNoTpl($row_['date']));
						$tpl->set('{uid}', $row_['user_id']);
						$tpl->set('{pid}', $pid);
						$tpl->compile('content');
					}
					$tpl->result['content'] .= '</div>';
				
				} else {
					$user_speedbar = 'Информация';
					msgbox('', '<div style="margin:0 auto; width:370px;text-align:center;height:65px;font-weight:bold">Вы не имеете прав для редактирования данного сообщества.<br><br><div class="button_blue fl_l" style="margin-left:115px;"><a href="/public'.$pid.'" onClick="Page.Go(this.href); return false"><button>На страницу сообщества</button></a></div></div>', 'info_red');
				}
			
			break;
			
			case "link":

				if(stripos($row['admin'], "u{$user_id}|") !== false) {
				
					$cnt_pages = intval($_POST['page_cnt']);
					if(!$_POST['page_cnt']) $page_cnt = 25;
					else $page_cnt = $cnt_pages*25;
					
					$metatags['title'] = 'Ссылки';
					$tpl->load_template('epage/link.tpl');
					$tpl->set('{pid}', $pid);
					$privaces = xfieldsdataload($row['privacy']);
					
					if($row['comments']) $tpl->set('{settings-comments}', 'comments');
					else $tpl->set('{settings-comments}', 'none');
					if($privaces['p_audio']) $tpl->set('{settings-audio}', 'audio');
					else $tpl->set('{settings-audio}', 'none');
					if($privaces['p_videos']) $tpl->set('{settings-videos}', 'videos');
					else $tpl->set('{settings-videos}', 'none');
					if($privaces['p_contact']) $tpl->set('{settings-contact}', 'contact');
					else $tpl->set('{settings-contact}', 'none');
					if($privaces['p_lastnews']) $tpl->set('{settings-lastnews}', 'lastnews');
					else $tpl->set('{settings-lastnews}', 'none');
					
					if($privaces['p_lastnews'] == 1){
					$tpl->set('[p_lastnews]', '');
					$tpl->set('[/p_lastnews]', '');
					} else
					$tpl->set_block("'\\[p_lastnews\\](.*?)\\[/p_lastnews\\]'si","");
					if(!$row['adres']) $tpl->set('{adres}', 'public'.$row['id']);
					else $tpl->set('{adres}', $row['adres']);
					
					if($real_admin or $a_row['level'] == '3'){
					$tpl->set('[noadmin_red]', '');
					$tpl->set('[/noadmin_red]', '');
					} else
					$tpl->set_block("'\\[noadmin_red\\](.*?)\\[/noadmin_red\\]'si","");
					
					$links = $db->super_query("SELECT COUNT(*) as cnt FROM `".PREFIX."_communities_links` WHERE pid = '{$pid}'");
					
					if(!$links['cnt']) {
						$tpl->set('{title}', 'На странице еще нет ссылок');
						$tpl->set('[no_links]','');
						$tpl->set('[/no_links]','');
					} else {
						$tpl->set('{title}', 'В сообществе '.$links['cnt'].' '.gram_record($links['cnt'], 'links'));
						$tpl->set_block("'\\[no_links\\](.*?)\\[/no_links\\]'si","");
					}
					$tpl->compile('content');
					
					$linkSQL = $db->super_query("SELECT link, photo, descr, name, id, outweb, screen FROM `".PREFIX."_communities_links` WHERE pid = '{$pid}' ORDER BY position ASC",1);
					
					$tpl->result['content'] .= '<div id="group_bl_rows"><div id="dragndrop" style="cursor:move"><ul>';
					foreach($linkSQL as $row_) {
						$tpl->load_template('epage/linktpl.tpl');
						$tpl->set('{lnk}', $row_['link']);
						$tpl->set('{ava}', $row_['photo']);
						$tpl->set('{name}', $row_['name']);
						$tpl->set('{descr}', $row_['descr']);
						$tpl->set('{ids}', $row_['id']);
						$tpl->set('{screen}', $row_['screen']);
						if($row_['outweb']) $tp = 2;
						else $tp = 1;
						$tpl->set('{types}', $tp);
						$tpl->compile('content');
					}
					$tpl->result['content'] .= '</ul></div></div>';
			
				} else {
					$user_speedbar = 'Информация';
					msgbox('', '<div style="margin:0 auto; width:370px;text-align:center;height:65px;font-weight:bold">Вы не имеете прав для редактирования данного сообщества.<br><br><div class="button_blue fl_l" style="margin-left:115px;"><a href="/public'.$pid.'" onClick="Page.Go(this.href); return false"><button>На страницу сообщества</button></a></div></div>', 'info_red');
				}
			
			break;
			
			case "parse_link":
				if(stripos($row['admin'], "u{$user_id}|") !== false) {
					$lnks = trim($_POST['lnk']);
					$actions = ajax_utf8(textFilter($_POST['actions'], false, true));
					if($actions == 'newLink') {
						$texted = ajax_utf8(textFilter($_POST['texted'], false, true));
						$screen = intval($_POST['screen']);
					}
					if(stripos($lnks, 'http://') !== false) $link = explode('http://',$lnks);
					else if(stripos($lnks, 'https://') !== false) $link = explode('https://',$lnks);
					else $linkE = explode('.', $lnks);
					if(!$linkE[1] and $link[1]) {
						$linkA = explode('\r',$link[1]);
						if(!$linkA[1]) $linkA = explode(' ',$link[1]);
						$linkB = explode(' ', $linkA[0]);
						$linkC = str_replace('http://', '', $linkB[0]);
					} else $linkC = $lnks;
					
					$spurl = explode('/', $linkC);
					if(strpos($lnks, 'id') == 0) {$spurl[0] = str_replace('id','',$spurl[0]);$reid = 1;}
					
					$spurl[0] = str_replace('www.','', $spurl[0]);
					
					if(stripos($lnks, 'https://') !== false) $tpg = str_replace('https://', '', $lnks);
					else $tpg = str_replace('http://', '', $lnks);
					$lnk = 'http://'.$tpg;
					
					if($spurl[0] != 'ivinete.ru' and ($reid != 1 or $link[1] or $linkE[1])) {
						$check_url = @get_headers(stripslashes($lnk));
						
						if($check_url) {
							$open_lnk = @file_get_contents($lnk);
							
							if(stripos(strtolower($open_lnk), 'charset=utf-8') OR stripos(strtolower($check_url[2]), 'charset=utf-8')) $open_lnk = ajax_utf8($open_lnk);
							
							preg_match("/<meta property=(\"|')og:title(\"|') content=(\"|')(.*?)(\"|')(.*?)>/is", $open_lnk, $parse_title);
							if(!$parse_title[4]) preg_match("/<meta name=(\"|')title(\"|') content=(\"|')(.*?)(\"|')(.*?)>/is", $open_lnk, $parse_title);

							$res_title = $parse_title[4];
							
							if(!$res_title){
								preg_match_all('`(<title>[^\[]+\</title>)`si', $open_lnk, $parse);
								$res_title = str_replace(array('<title>', '</title>'), '', $parse[1][0]);
							}

							preg_match("/<meta property=(\"|')og:description(\"|') content=(\"|')(.*?)(\"|')(.*?)>/is", $open_lnk, $parse_descr);
							if(!$parse_descr[4]) preg_match("/<meta name=(\"|')description(\"|') content=(\"|')(.*?)(\"|')(.*?)>/is", $open_lnk, $parse_descr);

							$res_descr = strip_tags($parse_descr[4]);
							$res_title = strip_tags($res_title);
							$open_lnk = preg_replace('`(<!--noindex-->|<noindex>).+?(<!--/noindex-->|</noindex>)`si', '', $open_lnk);

							preg_match("/<meta property=(\"|')og:image(\"|') content=(\"|')(.*?)(\"|')(.*?)>/is", $open_lnk, $parse_img);
							if(!$parse_img[4]) preg_match_all('/<img(.*?)src=\"(.*?)\"/', $open_lnk, $array);
							else $array[2][0] = $parse_img[4];

							$res_title = str_replace("|", "&#124;", $res_title);
							$res_descr = str_replace("|", "&#124;", $res_descr);
							$allowed_files = array('jpg', 'jpeg', 'jpe', 'png');
							$expImgs = explode('<img', $open_lnk);
							
							if($expImgs[1]){
								$i = 0;
								foreach($expImgs as $img){
									$exp1 = explode('src="', $img);
									$exp2 = explode('/>', $exp1[1]);
									$exp3 = explode('"', $exp2[0]);
									$expFormat = end(explode('.', $exp3[0]));
									
									if(in_array(strtolower($expFormat), $allowed_files)){
										$i++;
										
										$domain_url_name = explode('/', $lnk);
										$rdomain_url_name = str_replace('http://', '', $domain_url_name[2]);
										
										if(stripos(strtolower($exp3[0]), 'http://') === false) $new_imgs .= 'http://'.$rdomain_url_name.'/'.$exp3[0].'|';	
										else $new_imgs .= $exp3[0].'|';
											
										if($i == 1) $img_link = str_replace('|', '', $new_imgs);
									}
								}
							}
							
							preg_match("/<meta property=(\"|')og:image(\"|') content=(\"|')(.*?)(\"|')(.*?)>/is", $open_lnk, $parse_img);
							if($parse_img[4]){
								$img_link = $parse_img[4];
								if(!$new_imgs) $new_imgs = $img_link;
							}
							
							if(!$img_link and !$new_imgs) $img_link = $config['home_url'].'templates/Default/images/lnkouter100.gif';
							$new_imgs = $img_link.'|'.$new_imgs;
							$types = 1;
							
							if($actions == 'newLink') {
								$explodesimgs = explode('|',$new_imgs);
								if($screen<0 or $screen>count($explodesimgs)) $screen = 0;
								$photohead = str_replace('youtube.com///','',$explodesimgs[$screen-1]);
								$db->query("INSERT INTO `".PREFIX."_communities_links` SET pid = '{$pid}', link = '{$lnk}', photo = '{$photohead}', name = '{$texted}', descr = '{$spurl[0]}', position = '0', screen = '{$screen}'");
								$db->query("UPDATE `".PREFIX."_communities_links` SET links = links+1 WHERE id = '{$pid}'");
								$db->query("UPDATE `".PREFIX."_communities` SET links_num = links_num+1 WHERE id = '{$pid}'");
								echo $db->insert_id();
							}
						} else echo "link_error";
					} else if($spurl[0] != 'ivinete.ru' or $spurl[0] == 'ivinete.ru') {
						$arrs = explode('id', $spurl[1]);
						$spurl[0] = $arrs[1];
						$sql_where = "user_id = '{$spurl[0]}'";
						if(!$spurl[0]) {
							$spurl[0] = $spurl[1];
							$sql_where = "alias = '{$spurl[0]}'";
						}
						$spurl[0] = str_replace('id','',$spurl[0]);
						if(!$spurl[0]) {
							$spurl[0] = str_replace('id','',$lnks);
							if(is_numeric($spurl[0]) == true) $sql_where = "user_id = '{$spurl[0]}'";
							else $sql_where = "alias = '{$spurl[0]}'";
						}
						
						$spurlforif = str_replace('public','',str_replace('club','',$spurl[0]));
						
						if((is_numeric($spurlforif) == false and $spurlforif != '') or (is_numeric($spurlforif) == true and $spurlforif != 0)) {
							$row_user = $db->super_query("SELECT user_search_pref, user_photo, user_status, user_id FROM `".PREFIX."_users` WHERE {$sql_where}");
							if(!$row_user) {
								$sql_where = str_replace('user_id','id',str_replace('alias','adres',$sql_where));
								$spurl[0] = str_replace('public','',$spurl[0]);
								if(is_numeric($spurl[0]) == true) $sql_where = "id = '{$spurl[0]}'";
								else $sql_where = "adres = '{$spurl[0]}'";
								$row_public = $db->super_query("SELECT title, photo, id, traf FROM `".PREFIX."_communities` WHERE {$sql_where}");
								if(!$row_public) {
									if(is_numeric($spurl[0]) == true) $sql_where = "id = '{$spurl[0]}'";
									else $sql_where = "adres = '{$spurl[0]}'";
									$row_club = $db->super_query("SELECT title, photo, id, traf FROM `".PREFIX."_clubs` WHERE {$sql_where}");
									if($row_club) {
										$res_title = $row_club['title'];
										$res_descr = $row_club['traf'].' '.gram_record($row_club['traf'], 'apps');
										if($row_club['photo']) $img_link = $config['home_url'].'uploads/clubs/'.$row_club['id'].'/100_'.$row_club['photo'];
										$typeown = 3;$linkuid = $row_club['id'];
									} else $res = "link_error";
								} else if($row_public) {
									$res_title = $row_public['title'];
									$res_descr = $row_public['traf'].' '.gram_record($row_public['traf'], 'apps');
									if($row_public['photo']) $img_link = $config['home_url'].'uploads/groups/'.$row_public['id'].'/100_'.$row_public['photo'];
									$typeown = 2;$linkuid = $row_public['id'];
								} else $res = "link_error";
							} else if($row_user) {
								$res_title = $row_user['user_search_pref'];
								$res_descr = $row_user['user_status'];
								if($row_user['user_photo']) $img_link = $config['home_url'].'uploads/users/'.$row_user['user_id'].'/100_'.$row_user['user_photo'];
								$typeown = 1;$linkuid = $row_user['id'];
							} else $res = "link_error";
							
							if($img_link) $new_imgs = $img_link.'|'.$config['home_url'].'templates/Default/images/lnkinner100.gif';
							else {$new_imgs = $config['home_url'].'templates/Default/images/lnkinner100.gif';$img_link = $new_imgs;}
							$types = 2;
							
							if($actions == 'newLink') {
								$explodesimgs = explode('|',$new_imgs);
								if($screen<0 or $screen>count($explodesimgs)) $screen = 0;
								$photohead = $explodesimgs[$screen];
								$lnk = str_replace('http://','http://ivinete.ru/',$lnk);
								$outweb = $typeown.'|'.$linkuid;
								$db->query("INSERT INTO `".PREFIX."_communities_links` SET pid = '{$pid}', link = '{$lnk}', photo = '{$photohead}', name = '{$res_title}', descr = '{$texted}', position = '0', outweb = '{$outweb}', screen = '{$screen}'");
								$db->query("UPDATE `".PREFIX."_communities_links` SET links = links+1 WHERE id = '{$pid}'");
								$db->query("UPDATE `".PREFIX."_communities` SET links_num = links_num+1 WHERE id = '{$pid}'");
								echo $db->insert_id();
							}
						} else $res = "link_error";
					} else $res = "link_error";
					
					echo $res;
					if(!$res and $actions != 'newLink') echo $res_title.'<f>'.$res_descr.'<f>'.$img_link.'<f>'.$new_imgs.'<f>'.$spurl[0].'<f>'.$types;
				
				} else echo "no_admins";
				
				die();
			break;
			
			case "save_pos_links";
				NoAjaxQuery();
				$array = $_POST['group'];
				$count = 1;
				
				if(stripos($row['admin'], "u{$user_id}|") !== false) {
				
					foreach($array as $idval){
						$idval = intval($idval);
						$db->query("UPDATE `".PREFIX."_communities_links` SET position = '".$count."' WHERE id = '{$idval}' AND pid = '{$pid}'");
						$count++;	
					}
				
				} else echo "no_admins";
				
				die();
			break;
			
			case "saveLink";
				NoAjaxQuery();
				$id = $_POST['id'];
				$name = ajax_utf8(textFilter($_POST['name'], false, true));
				if(stripos($row['admin'], "u{$user_id}|") !== false) {
					$check = $db->super_query("SELECT outweb FROM `".PREFIX."_communities_links` WHERE pid = '{$pid}' and id = '{$id}'");
					if($check) {
						if($check['outweb']) $db->query("UPDATE `".PREFIX."_communities_links` SET descr = '{$name}' WHERE id = '{$id}' AND pid = '{$pid}'");
						else $db->query("UPDATE `".PREFIX."_communities_links` SET name = '{$name}' WHERE id = '{$id}' AND pid = '{$pid}'");
						if($check['outweb']) echo '1';
						else echo '2';
					} else echo "no_links";
				} else echo "no_admins";
				
				die();
			break;
			
			case "delLink";
				NoAjaxQuery();
				$id = $_POST['id'];
				
				if(stripos($row['admin'], "u{$user_id}|") !== false) {
					$check = $db->super_query("SELECT id FROM `".PREFIX."_communities_links` WHERE pid = '{$pid}' and id = '{$id}'");
					if($check) {
						$db->query("DELETE FROM `".PREFIX."_communities_links` WHERE id = '{$id}' AND pid = '{$pid}'");
						$db->query("UPDATE `".PREFIX."_communities_links` SET links = links-1 WHERE id = '{$pid}'");
						$db->query("UPDATE `".PREFIX."_communities` SET links_num = links_num-1 WHERE id = '{$pid}'");
					} else echo "no_links";
				} else echo "no_admins";
				
				die();
			break;
			
			case "delblacklist":
				NoAjaxQuery();
			
				$id = intval($_POST['id']);
			
				$check = $db->super_query("SELECT id FROM `".PREFIX."_communities_blacklist` WHERE user_id = '{$id}' and pid = '{$pid}'");
			
				if(stripos($row['admin'], "u{$user_id}|") !== false and $check and $row['real_admin'] != $id) {
				
					$db->query("DELETE FROM `".PREFIX."_communities_blacklist` WHERE user_id = '{$id}' and pid = '{$pid}'");
				
				} else echo "no_in_black_list";
				
				AjaxTpl();
				die();
			break;
			
			case "newblacklist":
				NoAjaxQuery();
			
				$id = intval($_POST['id']);
			
				$check = $db->super_query("SELECT id FROM `".PREFIX."_communities_blacklist` WHERE user_id = '{$id}' and pid = '{$pid}'");
			
				if(stripos($row['admin'], "u{$user_id}|") !== false and !$check and $row['real_admin'] != $id) {
				
					$db->query("INSERT INTO `".PREFIX."_communities_blacklist` SET user_id = '{$id}', pid = '{$pid}', date = '{$server_time}', admin = '{$user_id}'");
				
				} else echo "in_black_list";
				
				AjaxTpl();
				die();
			break;
			
			case "users":
			
				$tab = $_GET['tab'];

				if($real_admin or $a_row['level'] == '3') {
				
					if(!$_POST['page_cnt']) $page_cnt = 10;
					else $page_cnt = $_POST['page_cnt']*10;
					$explode_admins = array_slice(str_replace('|', '', explode('u', $row['admin'])), 0, $page_cnt);
					unset($explode_admins[0]);
					$explode_users = array_slice(str_replace('|','',explode('||', $row['ulist'])), 0, $page_cnt);
					
					$metatags['title'] = 'Участники';
					if(!$_POST['page_cnt']) {
						$tpl->load_template('epage/users.tpl');
						$tpl->set('{pid}', $pid);
						$privaces = xfieldsdataload($row['privacy']);
					
					if($row['comments']) $tpl->set('{settings-comments}', 'comments');
					else $tpl->set('{settings-comments}', 'none');
					if($privaces['p_audio']) $tpl->set('{settings-audio}', 'audio');
					else $tpl->set('{settings-audio}', 'none');
					if($privaces['p_videos']) $tpl->set('{settings-videos}', 'videos');
					else $tpl->set('{settings-videos}', 'none');
					if($privaces['p_contact']) $tpl->set('{settings-contact}', 'contact');
					else $tpl->set('{settings-contact}', 'none');
					if($privaces['p_lastnews']) $tpl->set('{settings-lastnews}', 'lastnews');
					else $tpl->set('{settings-lastnews}', 'none');
					if($privaces['p_links']) $tpl->set('{settings-lastnews}', 'lastnews');
					else $tpl->set('{settings-links}', 'none');
					
					if($privaces['p_lastnews'] == 1){
					$tpl->set('[p_lastnews]', '');
					$tpl->set('[/p_lastnews]', '');
					} else
					$tpl->set_block("'\\[p_lastnews\\](.*?)\\[/p_lastnews\\]'si","");
						if($tab == 'admin') {
							$tpl->set('{button_tab_b}', 'buttonsprofileSec');
							$tpl->set('{button_tab_a}', '');
							$tpl->set('{type}', 'admin');
							$tpl->set('[admin_page]','');
							$tpl->set('[/admin_page]','');
							$tpl->set_block("'\\[noadmin_page\\](.*?)\\[/noadmin_page\\]'si","");
						}
						else {
							$tpl->set('{button_tab_b}', '');
							$tpl->set('{button_tab_a}', 'buttonsprofileSec');
							$tpl->set('{type}', 'all');
							$tpl->set('[noadmin_page]','');
							$tpl->set('[/noadmin_page]','');
							$tpl->set_block("'\\[admin_page\\](.*?)\\[/admin_page\\]'si","");
						}
						if(!$row['adres']) $tpl->set('{adres}', 'public'.$row['id']);
						else $tpl->set('{adres}', $row['adres']);
						if($tab == 'admin') $tpl->set('{title}', 'В сообществе '.count($explode_admins).' '.gram_record($row['traf'], 'admins').'');
						else $tpl->set('{title}', 'В сообществе '.$row['traf'].' '.gram_record($row['traf'], 'apps').'');
						$tpl->set('{count}', $row['traf']);
					}
					
					if($_POST['page_cnt'])
						NoAjaxQuery();
					
					$tpl->compile('content');
					if(!$_POST['page_cnt']) $tpl->result['content'] .= '<table><tbody><tr><td id="all_users">';
					if(!$tab == 'admin') $foreach = $explode_users;
					else $foreach = $explode_admins;
					foreach($foreach as $user) {
						$p_user = $db->super_query("SELECT user_search_pref, user_photo, alias, user_last_visit FROM `".PREFIX."_users` WHERE user_id = '{$user}'");
						$a_user = $db->super_query("SELECT level FROM `".PREFIX."_communities_admins` WHERE user_id = '{$user}'");
						$tpl->load_template('epage/user.tpl');
						$tpl->set('{uid}', $user);
						$tpl->set('{name}', $p_user['user_search_pref']);
						$tpl->set('{ava}', $p_user['user_photo']);
						if($a_user) {
							if($row['real_admin'] == $user) $tpl->set('{tags}', '<b>Создатель</b>');
							else $tpl->set('{tags}');
							$tpl->set('{view_tags}','');
						} else {$tpl->set('{view_tags}','no_display');$tpl->set('{tags}', '');}
						if($p_user['user_last_visit'] >= $online_time) {
							$tpl->set('[online]','');
							$tpl->set('[/online]','');
						} else $tpl->set_block("'\\[online\\](.*?)\\[/online\\]'si","");
						if($p_user['alias']) $alias = $p_user['alias'];
						else $alias = 'u'.$user;
						$tpl->set('{adres}', $alias);
						if($p_user['user_photo']) $avatar = '/uploads/users/'.$user.'/100_'.$p_user['user_photo'].'';
						else $avatar = '/templates/Default/images/100_no_ava.png';
						$tpl->set('{ava_photo}', $avatar);
						
						if($real_admin or $a_row['level'] == '1'){
							$tpl->set('[adminreal]', '');
							$tpl->set('[/adminreal]', '');
						} else
							$tpl->set_block("'\\[adminreal\\](.*?)\\[/adminreal\\]'si","");
						
						if(in_array($user, $explode_admins)) {
							if($user != $row['real_admin']) {
								$tpl->set('[yes_admin]','');
								$tpl->set('[/yes_admin]','');
							} else $tpl->set_block("'\\[yes_admin\\](.*?)\\[/yes_admin\\]'si","");
							$tpl->set_block("'\\[no_admin\\](.*?)\\[/no_admin\\]'si","");
							$tpl->set_block("'\\[admin\\](.*?)\\[/admin\\]'si","");
						}
						else {
							if($user != $row['real_admin']) {
								$tpl->set('[no_admin]','');
								$tpl->set('[/no_admin]','');
							} else $tpl->set_block("'\\[no_admin\\](.*?)\\[/no_admin\\]'si","");
							$tpl->set_block("'\\[yes_admin\\](.*?)\\[/yes_admin\\]'si","");
							$tpl->set_block("'\\[admin\\](.*?)\\[/admin\\]'si","");
						}
						$tpl->compile('content');
					}
					if(!$_POST['page_cnt']) $tpl->result['content'] .= '</td></tr></tbody></table>';
				
					if($_POST['page_cnt']){
						AjaxTpl();
						exit;
					}
				
				} else {
					$user_speedbar = 'Информация';
					msgbox('', '<div style="margin:0 auto; width:370px;text-align:center;height:65px;font-weight:bold">Вы не имеете прав для редактирования данного сообщества.<br><br><div class="button_blue fl_l" style="margin-left:115px;"><a href="/public'.$pid.'" onClick="Page.Go(this.href); return false"><button>На страницу сообщества</button></a></div></div>', 'info_red');
				}
			
			break;
			
			case "editadmin":
				NoAjaxQuery();
			
				$id = intval($_POST['id']);
				$type = ajax_utf8(textFilter($_POST['type'], false, true));
			
				if(stripos($row['admin'], "u{$user_id}|") !== false and stripos($row['admin'], "u{$id}|") !== false or $type == 'newadmin' and $row['real_admin'] != $id) {
				
					$rows = $db->super_query("SELECT user_search_pref, alias, user_photo FROM `".PREFIX."_users` WHERE user_id = '{$id}'");
					$a_row = $db->super_query("SELECT level FROM `".PREFIX."_communities_admins` WHERE user_id = '{$id}' and pid = '{$pid}'");
					$feed_row = $db->super_query("SELECT office, fphone, femail, visible FROM `".PREFIX."_communities_feedback` WHERE fuser_id = '{$id}' and cid = '{$pid}'");
					if($rows['alias']) $alias = $rows['alias'];
					else $alias = $id;
					if($feed_row['femail'] == '') {$dh = 'no_display'; $dc = '';}
					else {$dh = ''; $dc = 'no_display';}
					if($feed_row['fphone'] == '') {$dhp = 'no_display'; $dcp = '';}
					else {$dhp = ''; $dcp = 'no_display';}
					if($a_row['level'] == 1) $ok1 = 'on';
					else if($a_row['level'] == 2) $ok2 = 'on';
					else if($a_row['level'] == 3 or $type == 'newadmin') $ok3 = 'on';
					if($feed_row['visible']) {$contblock = 'blockcontact';}
					else {$contblock = '';}
					if($type == 'newadmin') $rowlevel = 3;
					else $rowlevel = $a_row['level'];
					if($rows['user_photo']) $avatars = '/uploads/users/'.$id.'/50_'.$rows['user_photo'].'';
					else $avatars = '/templates/Default/images/no_ava_50.png';
					$f = "'";
					if($type == 'editadmin' or $type == 'newadmin') {$blocklevel = '
	<div class="videos_text" style="margin-bottom: 5px;">Уровень полномочий</div><input id="value_type" type="hidden" value="'.$rowlevel.'"/><div>
	<div class="radiobtn settings_reason '.$ok3.'" onclick="radiobtn.select('.$f.'value_type'.$f.',3);" style="padding-top:10px;"><div></div>Модератор</div><div class="groups_create_about">Может удалять добавленные пользователями материалы, управлять черным списком сообщества</div></div><br>
	<div><div class="radiobtn settings_reason '.$ok2.'" onclick="radiobtn.select('.$f.'value_type'.$f.',2);"><div></div>Редактор</div><div class="groups_create_about">Может писать от имени сообщества, добавлять, удалять и редактировать контент, обновлять главную фотографию</div>
	</div><br><div><div class="radiobtn settings_reason '.$ok1.'" onclick="radiobtn.select('.$f.'value_type'.$f.',1);"><div></div>Администратор</div><div class="groups_create_about">Может назначать и снимать администраторов, изменять название и адрес сообщества</div></div>';$type1 = 'назначить';$type2 = 'руководителем сообщества';}
					else {$blocklevel = '<div style="margin-top:-10px;"></div>';$type1 = 'убрать';$type2 = 'из руководителей сообщества';}
					$temp = '
	<div style="padding:15px"><script type="text/javascript">$(document).ready(function(){myhtml.checked(["'.$contblock.'"]);});</script><div class="gedit_admbox_top clear_fix"><a href="/id'.$id.'" class="gedit_admbox_thumb fl_l" target="_blank"><img class="gedit_admbox_img" src="'.$avatars.'"></a>
	<div class="gedit_admbox_info fl_l">Вы собираетесь '.$type1.' <a href="/id'.$id.'" target="_blank">'.$rows['user_search_pref'].'</a> '.$type2.'.</div>
	</div>'.$blocklevel.'<div class="html_checkbox" id="blockcontact" onclick="myhtml.checkbox(this.id);" style="margin-top: 15px;">Отображать в блоке контактов</div><div class="clear"></div><div id="gedit_admbox_contact_info" class="no_display">
	<div class="gedit_admbox_contact_row clear_fix"><input type="text" id="gedit_admbox_position" class="inpst fl_l" maxlength="100"  style="width:170px;" value="'.$feed_row['office'].'" /><div class="gedit_admbox_contact_desc fl_l">укажите должность</div>
	</div><div class="gedit_admbox_contact_row clear_fix '.$dh.'" id="gedit_admbox_email_row"><input type="text" id="gedit_admbox_email" class="inpst fl_l" maxlength="100"  style="width:170px;" value="'.$feed_row['femail'].'" />
	<div class="gedit_admbox_contact_desc fl_l">укажите e-mail</div></div><div class="gedit_admbox_contact_fill '.$dc.'" id="gedit_admbox_email_fill"><a id="gedit_admbox_email" onclick="myhtml.toggleBlocks(this.id);" style="cursor:pointer">указать контактный e-mail</a></div>
	<div class="gedit_admbox_contact_row clear_fix '.$dhp.'" id="gedit_admbox_phone_row">
	<input type="text" id="gedit_admbox_phone" class="inpst fl_l" maxlength="100"  style="width:170px;" value="'.$feed_row['fphone'].'" />
	<div class="gedit_admbox_contact_desc fl_l">укажите телефон</div></div><div class="gedit_admbox_contact_fill '.$dcp.'" id="gedit_admbox_phone_fill"><a id="gedit_admbox_phone" onclick="myhtml.toggleBlocks(this.id);" style="cursor:pointer">указать контактный телефон</a></div></div></div>';
				
					echo $temp;
				
				} else echo "no_admin_lc";
				
				AjaxTpl();
				die();
			break;
			
			case "saveadmin":
				NoAjaxQuery();
			
				$id = intval($_POST['id']);
				$level = intval($_POST['level']);
				$blockf = intval($_POST['blockf']);
				$position = ajax_utf8(textFilter($_POST['position'], false, true));
				$email = ajax_utf8(textFilter($_POST['email'], false, true));
				$phone = ajax_utf8(textFilter($_POST['phone'], false, true));
				$type = ajax_utf8(textFilter($_POST['type'], false, true));
			
				if(stripos($row['admin'], "u{$user_id}|") !== false and stripos($row['admin'], "u{$id}|") !== false or $type == 'newadmin' and $row['real_admin'] != $id) {
				
					if($level<0 or $level>3) $level = 3;
					if($blockf<0 or $blockf>1) $blockf = 0;
					
					if($type == 'newadmin' and stripos($row['admin'], "u{$id}|") === false) {
						$admins = $row['admin'].'u'.$id.'|';
						$db->query("UPDATE `".PREFIX."_communities` SET admin = '{$admins}' WHERE id = '{$pid}'");
					}
				
					$select = $db->super_query("SELECT level FROM `".PREFIX."_communities_admins` WHERE user_id = '{$id}' and pid = '{$pid}'");
					
					if(!$select) $db->query("INSERT INTO `".PREFIX."_communities_admins` SET user_id = '{$id}', pid = '{$pid}', level = '{$level}'");
					else $db->query("UPDATE `".PREFIX."_communities_admins` SET level = '{$level}' WHERE user_id = '{$id}' and pid = '{$pid}'");
					
					$feedback = $db->super_query("SELECT fuser_id, visible FROM `".PREFIX."_communities_feedback` WHERE fuser_id = '{$id}' and cid = '{$pid}'");
					
					if($blockf) {
						if(!$feedback) {
							$db->query("INSERT INTO `".PREFIX."_communities_feedback` SET fuser_id = '{$id}', cid = '{$pid}', visible = '1', fdate = '{$server_time}', office = '{$position}', fphone = '{$phone}', femail = '{$email}'");
							$db->query("UPDATE `".PREFIX."_communities` SET feedback = feedback+1 WHERE id = '{$pid}'");
						} else {
							if($feedback['visible'] == 0) $db->query("UPDATE `".PREFIX."_communities` SET feedback = feedback+1 WHERE id = '{$pid}'");
							$db->query("UPDATE `".PREFIX."_communities_feedback` SET visible = '1', fdate = '{$server_time}', office = '{$position}', fphone = '{$phone}', femail = '{$email}' WHERE fuser_id = '{$id}' and cid = '{$pid}'");
						}
					} else {
						if($feedback) {
							$db->query("UPDATE `".PREFIX."_communities_feedback` SET visible = '0' WHERE fuser_id = '{$id}' and cid = '{$pid}'");
							if($feedback['visible'] == 1) $db->query("UPDATE `".PREFIX."_communities` SET feedback = feedback-1 WHERE id = '{$pid}'");
						}
					}
				
				} else echo "no_admin_lc";
				
				AjaxTpl();
				die();
			break;
			
			case "deleteadmin":
				NoAjaxQuery();
			
				$id = intval($_POST['id']);
				$blockf = intval($_POST['blockf']);
				$position = ajax_utf8(textFilter($_POST['position'], false, true));
				$email = ajax_utf8(textFilter($_POST['email'], false, true));
				$phone = ajax_utf8(textFilter($_POST['phone'], false, true));
			
				if(stripos($row['admin'], "u{$user_id}|") !== false and stripos($row['admin'], "u{$id}|") !== false and $row['real_admin'] != $id) {
				
					if($blockf<0 or $blockf>1) $blockf = 0;
					
					$db->query("UPDATE `".PREFIX."_communities` SET admin = REPLACE(admin, 'u{$id}|', '') WHERE id = '{$pid}'");
					$db->query("DELETE FROM `".PREFIX."_communities_admins` WHERE user_id = '{$id}' and pid = '{$pid}'");
					
					$feedback = $db->super_query("SELECT fuser_id, visible FROM `".PREFIX."_communities_feedback` WHERE fuser_id = '{$id}' and cid = '{$pid}'");
					
					if($blockf) {
						if(!$feedback) {
							$db->query("INSERT INTO `".PREFIX."_communities_feedback` SET fuser_id = '{$id}', cid = '{$pid}', visible = '1', fdate = '{$server_time}', office = '{$position}', fphone = '{$phone}', femail = '{$email}'");
							$db->query("UPDATE `".PREFIX."_communities` SET feedback = feedback+1 WHERE id = '{$pid}'");
						} else {
							if($feedback['visible'] == 0) $db->query("UPDATE `".PREFIX."_communities` SET feedback = feedback+1 WHERE id = '{$pid}'");
							$db->query("UPDATE `".PREFIX."_communities_feedback` SET visible = '1', fdate = '{$server_time}', office = '{$position}', fphone = '{$phone}', femail = '{$email}' WHERE fuser_id = '{$id}' and cid = '{$pid}'");
						}
					} else {
						if($feedback) {
							$db->query("DELETE FROM `".PREFIX."_communities_feedback` WHERE fuser_id = '{$id}' and cid = '{$pid}'");
							$db->query("UPDATE `".PREFIX."_communities` SET feedback = feedback-1 WHERE id = '{$pid}'");
						}
					}
				
				} else echo "no_admin_lc";
				
				AjaxTpl();
				die();
			break;
			
			case "deleteusers":
				NoAjaxQuery();
			
				$id = intval($_POST['id']);
			
				if(stripos($row['admin'], "u{$user_id}|") !== false and stripos($row['admin'], "u{$id}|") === false and stripos($row['ulist'], "|{$id}|") !== false and $row['real_admin'] != $id) {
					
					$db->query("UPDATE `".PREFIX."_communities` SET ulist = REPLACE(ulist, '|{$id}|', ''), traf = traf-1 WHERE id = '{$pid}'");
					$db->query("DELETE FROM `".PREFIX."_friends` WHERE user_id = '{$id}' and friend_id = '{$pid}' and subscriptions = '2'");
					$db->query("INSERT INTO `".PREFIX."_friends` SET user_id = '{$id}', friend_id = '{$pid}', subscriptions = '4', friends_date = '{$server_time}'");
					$db->query("UPDATE `".PREFIX."_users` SET user_public_num = user_public_num-1 WHERE user_id = '{$id}'");
				
				} else echo "no_users";
				
				AjaxTpl();
				die();
			break;
			
			case "rebornusers":
				NoAjaxQuery();
			
				$id = intval($_POST['id']);
			
				$check_users_reborn = $db->super_query("SELECT user_id FROM `".PREFIX."_friends` WHERE user_id = '{$id}' and friend_id = '{$pid}' and subscriptions = '4'");
			
				if(stripos($row['admin'], "u{$user_id}|") !== false and $check_users_reborn and $row['real_admin'] != $id) {
					
					$ulistnew = $row['ulist'].'|'.$id.'|';
					$db->query("UPDATE `".PREFIX."_communities` SET ulist = '{$ulistnew}', traf = traf+1 WHERE id = '{$pid}'");
					$db->query("DELETE FROM `".PREFIX."_friends` WHERE user_id = '{$id}' and friend_id = '{$pid}' and subscriptions = '4'");
					$db->query("INSERT INTO `".PREFIX."_friends` SET user_id = '{$id}', friend_id = '{$pid}', subscriptions = '2', friends_date = '{$server_time}'");
					$db->query("UPDATE `".PREFIX."_users` SET user_public_num = user_public_num+1 WHERE user_id = '{$id}'");
				
				} else echo "no_reborn_users";
				
				AjaxTpl();
				die();
			break;
			
			case "miniature":
				if(stripos($row['admin'], "u{$user_id}|") !== false) {
				$row = $db->super_query("SELECT photo FROM `".PREFIX."_communities` WHERE id = '{$pid}'");
				
				if($row['photo']){
					$tpl->load_template('miniature/mainpage.tpl');
					$tpl->set('{pid}', $pid);
					$tpl->set('{ava}', $row['photo']);
					$tpl->compile('content');
					AjaxTpl();
				} else echo '1';
				} else echo "no_admins";
				exit();
			break;
			
			case "miniature_save":
				if(stripos($row['admin'], "u{$user_id}|") !== false) {
				$row = $db->super_query("SELECT photo,adres FROM `".PREFIX."_communities` WHERE id = '{$pid}'");

				$i_left = intval($_POST['i_left']);
				$i_top = intval($_POST['i_top']);
				$i_width = intval($_POST['i_width']);
				$i_height = intval($_POST['i_height']);

				if($row['photo'] AND $i_width >= 100 AND $i_height >= 100 AND $i_left >= 0 AND $i_height >= 0){
					include_once ENGINE_DIR.'/classes/images.php';

					$tmb = new thumbnail(ROOT_DIR."/uploads/groups/{$pid}/{$row['photo']}");
					$tmb->size_auto($i_width."x".$i_height, 0, "{$i_left}|{$i_top}");
					$tmb->jpeg_quality(100);
					$tmb->save(ROOT_DIR."/uploads/groups/{$pid}/100_{$row['photo']}");
					
					$tmb = new thumbnail(ROOT_DIR."/uploads/groups/{$pid}/100_{$row['photo']}");
					$tmb->size_auto("100x100", 1);
					$tmb->jpeg_quality(100);
					$tmb->save(ROOT_DIR."/uploads/groups/{$pid}/100_{$row['photo']}");
					
					$tmb = new thumbnail(ROOT_DIR."/uploads/groups/{$pid}/100_{$row['photo']}");
					$tmb->size_auto("50x50");
					$tmb->jpeg_quality(100);
					$tmb->save(ROOT_DIR."/uploads/groups/{$pid}/50_{$row['photo']}");
					
					if($row['adres']) echo $row['adres'];
					else echo 'public'.$pid;
					
				} else echo 'err';
				} else echo "no_admins";
				
				exit();
			break;
			
			case "vphoto":
				$uid = intval($_POST['uid']);
				
				if($_POST['type'])
					$photo = ROOT_DIR."/uploads/attach/{$uid}/{$_POST['photo']}";
				else
					$photo = ROOT_DIR."/uploads/groups/{$uid}/{$_POST['photo']}";
				
				if(file_exists($photo)){
					$tpl->load_template('photos/photo_profile.tpl');
					$tpl->set('{uid}', $uid);
					if($_POST['type'])
						$tpl->set('{photo}', "/uploads/attach/{$uid}/{$_POST['photo']}");
					else
						$tpl->set('{photo}', "/uploads/groups/{$uid}/o_{$_POST['photo']}");
					$tpl->set('{close-link}', $_POST['close_link']);
					$tpl->compile('content');
					AjaxTpl();
				} else
					echo 'no_photo';
			break;
			
			case "vphoto_wall":
				$uid = intval($_POST['uid']);
				
				if($_POST['type'])
					$photo = ROOT_DIR."/uploads/attach/{$uid}/{$_POST['photo']}";
				else
					$photo = ROOT_DIR."/uploads/groups/{$uid}/{$_POST['photo']}";
				
				if(file_exists($photo)){
					$tpl->load_template('photos/photo_profile.tpl');
					$tpl->set('{uid}', $uid);
					if($_POST['type'])
						$tpl->set('{photo}', "/uploads/attach/{$uid}/{$_POST['photo']}");
					else
						$tpl->set('{photo}', "/uploads/groups/{$uid}/{$_POST['photo']}");
					$tpl->set('{close-link}', $_POST['close_link']);
					$tpl->compile('content');
					AjaxTpl();
				} else
					echo 'no_photo';
			break;
			
		}
	
	$db->free();
	$tpl->clear();
	
} else {
	$user_speedbar = 'Информация';
	msgbox('', $lang['not_logged'], 'info');
}
?>