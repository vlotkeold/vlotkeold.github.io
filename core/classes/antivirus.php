<?php
/* 
	Appointment: Проверка файлов на наличие посторонних
	File: antivirus.php
 
*/

class antivirus{
	var $bad_files       = array();
	var $snap_files      = array();
	var $track_files      = array();
	var $snap      		 = false;
	var $checked_folders = array();
	var $dir_split       = '/';

	var $cache_files       = array(
		"./core/cache/core/country.php",
		"./core/cache/core/country_city_.php",
		"./core/cache/core/country_city_1.php",
		"./core/cache/core/country_city_2.php",
		"./core/cache/core/country_city_3.php",
		"./core/cache/core/country_city_4.php",
		"./core/cache/core/country_city_5.php",
		"./core/cache/core/country_city_6.php",
		"./core/cache/core/country_city_7.php",
		"./core/cache/core/country_city_8.php",
		"./core/cache/core/country_city_9.php",
		"./core/cache/core/country_city_10.php",
		"./core/cache/core/country_city_11.php",
		"./core/cache/core/country_city_12.php",
		"./core/cache/core/country_city_13.php",
		"./core/cache/core/country_city_14.php",
		"./core/cache/core/country_city_15.php",
		"./core/cache/core/country_city_16.php",
		"./core/cache/core/country_city_17.php",
		"./core/cache/core/country_city_18.php",
		"./core/cache/core/country_city_19.php",
		"./core/cache/core/country_city_20.php",
		"./core/cache/core/country_city_21.php",
		"./core/cache/core/country_city_22.php",
		"./core/cache/core/country_city_23.php",
		"./core/cache/core/country_city_24.php",
		"./core/cache/core/country_city_25.php",
	);

	var $good_files       = array(
		"./.htaccess",
		"./backup/.htaccess",
		"./core/cache/.htaccess",
		"./core/cache/core/.htaccess",
		"./config/.htaccess",
		"./lang/.htaccess",
		"./uploads/.htaccess",
		"./uploads/smiles/.htaccess",
		"./uploads/gifts/.htaccess",
		"./core/classes/antivirus.php",
		"./core/classes/id3v2.php",
		"./core/classes/images.php",
		"./core/classes/mail.php",
		"./core/classes/mysql.php",
		"./core/classes/parse.php",
		"./core/classes/templates.php",
		"./core/classes/wall.php",
		"./core/classes/wall.public.php",
		"./config/config.php",
		"./config/db.php",
		"./core/inc/antivirus.php",
		"./core/inc/ban.php",
		"./core/inc/db.php",
		"./core/inc/dumper.php",
		"./core/inc/functions.php",
		"./core/inc/gifts.php",
		"./core/inc/groups.php",
		"./core/inc/login.php",
		"./core/inc/mail.php",
		"./core/inc/mail_tpl.php",
		"./core/inc/main.php",
		"./core/inc/massaction.php",
		"./core/inc/mod.php",
		"./core/inc/mysettings.php",
		"./core/inc/notes.php",
		"./core/inc/search.php",
		"./core/inc/static.php",
		"./core/inc/core.php",
		"./core/inc/tpl.php",
		"./core/inc/users.php",
		"./core/inc/videos.php",
		"./core/inc/albums.php",
		"./core/inc/musics.php",
		"./core/inc/stats.php",
		"./core/inc/logs.php",
		"./core/inc/country.php",
		"./core/inc/city.php",
		"./core/modules/albums.php",
		"./core/modules/attach.php",
		"./core/modules/attach_groups.php",
		"./core/modules/audio.php",
		"./core/modules/balance.php",
		"./core/modules/blog.php",
		"./core/modules/editprofile.php",
		"./core/modules/fave.php",
		"./core/modules/friends.php",
		"./core/modules/functions.php",
		"./core/modules/gifts.php",
		"./core/modules/groups.php",
		"./core/modules/gzip.php",
		"./core/modules/im.php",
		"./core/modules/loadcity.php",
		"./core/modules/login.php",
		"./core/modules/messages.php",
		"./core/modules/news.php",
		"./core/modules/notes.php",
		"./core/modules/photo.php",
		"./core/modules/profile.php",
		"./core/modules/public.php",
		"./core/modules/register.php",
		"./core/modules/register_main.php",
		"./core/modules/restore.php",
		"./core/modules/search.php",
		"./core/modules/settings.php",
		"./core/modules/status.php",
		"./core/modules/subscriptions.php",
		"./core/modules/support.php",
		"./core/modules/video.php",
		"./core/modules/videos.php",
		"./core/modules/wall.php",
		"./core/init.php",
		"./core/mod.php",
		"./badbrowser.php",
		"./controlpanel.php",
		"./index.php",
		"./antibot/antibot.php",
		"./antibot/sec_code.php",
		"./core/modules/profile_delet.php",
		"./core/modules/profile_ban.php",
		"./core/modules/offline.php",
		"./core/classes/download.php",
		"./core/inc/report.php",
		"./core/inc/xfields.php",
		"./core/modules/distinguish.php",
		"./core/modules/doc.php",
		"./core/modules/fast_search.php",
		"./core/modules/public_audio.php",
		"./core/modules/report.php",
		"./core/modules/repost.php",
		"./core/modules/static.php",
		"./core/modules/updates.php",
		"./core/modules/votes.php",
		"./uploads/doc/.htaccess",
		"./min/config.php",
		"./min/groupsConfig.php",
		"./min/index.php",
		"./min/lib/FirePHP.php",
		"./min/lib/HTTP/ConditionalGet.php",
		"./min/lib/HTTP/Encoder.php",
		"./min/lib/JSMin.php",
		"./min/lib/JSMinPlus.php",
		"./min/lib/Minify/Build.php",
		"./min/lib/Minify/Cache/APC.php",
		"./min/lib/Minify/Cache/File.php",
		"./min/lib/Minify/Cache/Memcache.php",
		"./min/lib/Minify/CommentPreserver.php",
		"./min/lib/Minify/Controller/Base.php",
		"./min/lib/Minify/Controller/Files.php",
		"./min/lib/Minify/Controller/Groups.php",
		"./min/lib/Minify/Controller/MinApp.php",
		"./min/lib/Minify/Controller/Page.php",
		"./min/lib/Minify/Controller/Version1.php",
		"./min/lib/Minify/CSS/Compressor.php",
		"./min/lib/Minify/CSS/UriRewriter.php",
		"./min/lib/Minify/CSS.php",
		"./min/lib/Minify/HTML.php",
		"./min/lib/Minify/ImportProcessor.php",
		"./min/lib/Minify/Lines.php",
		"./min/lib/Minify/Logger.php",
		"./min/lib/Minify/Packer.php",
		"./min/lib/Minify/Source.php",
		"./min/lib/Minify/YUICompressor.php",
		"./min/lib/Minify.php",
		"./min/lib/Solar/Dir.php",
	);

	function antivirus ()
	{
		if(@file_exists(CONFIG_DIR.'/snap.db')) {
  			$filecontents = file(CONFIG_DIR.'/snap.db');

		    foreach ($filecontents as $name => $value) {
	    	  $filecontents[$name] = explode("|", trim($value));
	    	    $this->track_files[$filecontents[$name][0]] = $filecontents[$name][1];
		    }
			$this->snap = true;

		}

	}
	
	function scan_files( $dir, $snap = false, $access = false )
	{
		$this->checked_folders[] = $dir . $this->dir_split . $file;
	
		if ( $dh = @opendir( $dir ) )
		{
			while ( false !== ( $file = readdir($dh) ) )
			{
				if ( $file == '.' or $file == '..' or $file == '.svn' or $file == '.DS_store' )
				{
					continue;
				}
		
				if ( is_dir( $dir . $this->dir_split . $file ) )
				{

					if ($dir != ROOT_DIR)
					$this->scan_files( $dir . $this->dir_split . $file, $snap, $access );
				}
				else
				{

					if ($this->snap OR $snap) $templates = "|tpl|js|lng|htaccess"; elseif($access) $templates = "|htaccess"; else $templates = "";

					if ( preg_match( "#.*\.(php|cgi|pl|perl|php3|php4|php5|php6".$templates.")#i", $file ) )
					{

					  $folder = str_replace(ROOT_DIR, ".",$dir);
					  $file_size = filesize($dir . $this->dir_split . $file);
					  $file_crc = md5_file($dir . $this->dir_split . $file);
					  $file_date = date("d.m.Y H:i:s", filectime($dir . $this->dir_split . $file));

					  if ($snap) {

						$this->snap_files[] = array( 'file_path' => $folder . $this->dir_split . $file,
													 'file_crc' => $file_crc );


                      } else {

						if ($this->snap) {


							if ($this->track_files[$folder . $this->dir_split . $file] != $file_crc AND !in_array($folder . $this->dir_split . $file, $this->cache_files))
							$this->bad_files[] = array( 'file_path' => $folder . $this->dir_split . $file,
													'file_name' => $file,
													'file_date' => $file_date,
													'type' => 1,
													'file_size' => $file_size );

					    } else { 

						 if (!in_array($folder . $this->dir_split . $file, $this->good_files))
						 $this->bad_files[] = array( 'file_path' => $folder . $this->dir_split . $file,
													'file_name' => $file,
													'file_date' => $file_date,
													'type' => 0,
													'file_size' => $file_size ); 

						}

					  }
					}
				}
			}
		}
	}
}

?>