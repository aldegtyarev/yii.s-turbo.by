<?php
define('DS', DIRECTORY_SEPARATOR);
/**
 * Плагин заменяет изображения иконками со ссылкой на полную версию.
 */
class AadThumbnails
{

	/**
	 * Объект - тег изображения
	 * @var plgContentMavikThumbnailsImgTag
	 */
	var $img;
	
	/**
	 * Имя оригинального изображения
	 * @var string
	 */
	var $origImgName;
	
	/**
	 * Оригинальный адрес изобажения
	 * @var string
	 */
	var $originalSrc;
	
	/**
	 * Размеры оригинального изображения
	 * @var array
	 */
	var $origImgSize;
	
	/**
	 * Каталоги с иконками
	 * @var array
	 */
	var $thumbPath;

	/**
	 * Каталог с иконками по умолчанию
	 * @var string
	 */
	var $thumbPathDefault;
	
	
	/**
	 * Создавать ли подпапки в директории с иконками
	 * @var boolean
	 */
	var $thumbPathSubdir;
	
	/**
	 * Каталог с копиями изображений с других серверов
	 * @var string
	 */
	var $remotePath;

	/**
	 * Тип всплывающего окна
	 * @var string
	 */
	var $popupType;
	
	/**
	 * Подключать ли ява-скрипты
	 *
	 * @var boolean
	 */
	var $linkScripts;
	
	/**
	 * Отображать изображение увеличительного стекла на картинке
	 * @var boolean
	 */
	var $zoominImg;
	
	/**
	 * Менять ли курсор при наведении на картинку на увеличительное стекло
	 * @var boolean
	 */
	var $zoominCur;
	
	/**
	 * В блогах изображение является ссылкой на полный текст
	 * @var boolean
	 */
	var $blogLink;

	/**
	 * Объект для работы с блогом
	 * @var object
	 */
	var $blogHelper;
	
	/**
	 * Ссылка на статью
	 * @var object
	 */
	var $article;
	
	/**
	 * Ссылка на параметры статьи
	 * @var object
	 */
	var $articleParams;
	
	/**
	 * Декоратор тега изображения (зависит от popupType)
	 * @var plgContentMavikThumbnailsDecorator
	 */
	var $decorator;

	/**
	 * Добевлены уже декларации в head
	 * @var boolean
	 */
	var $has_header;
	
	/**
	 * Размеры по умолчанию применять для
	 * @var string
	 */
	var $defaultSize;

	/**
	 * Ширина по-умолчанию
	 * @var int
	 */
	var $defaultWidth;
	
	/**
	 * Высота по-умолчанию
	 * @var int
	 */
	var $defaultHeight;

	/**
	 * Размеры по умолчанию применять в блоках для
	 * @var string
	 */
	var $blogDefaultSize;

	/**
	 * Ширина по-умолчанию в блоках
	 * @var int
	 */
	var $blogDefaultWidth;

	/**
	 * Высота по-умолчанию в блогах
	 * @var int
	 */
	var $blogDefaultHeight;
	
	/**
	 * Качество jpg-файлов
	 * @var int
	 */
	var $quality;

	/**
	 * Создавать иконки для ...
	 * @var int
	 */
	var $thumbnailsFor;

	/**
	 * Список классов для которых (не)надо создавать иконки
	 * @var string
	 */
	var $class;

	/**
	* Путь к плагину
	* @var string
	*/
	var $path;

	/**
	* URL путь к плагину
	* @var string
	*/
	var $url;

	/**
	* Линейка Joomla
	* @var string
	*/
	var $jVersion;

	/**
	 * Содержит функции зависящие от метода ресайзинга:
	 * сохранение пропорций, обрезка, искажение и т.д.
	 * @var object
	 */
	var $proportionsStrategy;


	/**
	* Конструктор
	* @param object $subject Обрабатываемый объект
	* @param object $params  Объект содержащий параметры плагина
	*/
	function plgContentMavikThumbnails( )
	{
		$this->path = Yii::app()->basePath."/components";
		/*
		$app =& JFactory::getApplication();
		
		// Подстроиться под версию Joomla
		$this->jVersion = substr(JVERSION, 0, 3);
		if($this->jVersion == '1.5') {
			// 1.5
			$this->path = JPATH_PLUGINS.DS.'content';
			$this->url = JURI::base(true).'/plugins/content';
		} else {
			// 1.6
			$this->path = JPATH_PLUGINS.DS.'content'.DS.'mavikthumbnails';
			$this->url = JURI::base(true).'/plugins/content/mavikthumbnails';
		}

		// Заплатка для компонентов использующих старый механизм работы с плагинами 
		if ($this->jVersion == '1.5' && !is_object($params)) {
			$this->plugin = &JPluginHelper::getPlugin('content', 'mavikthumbnails');
			$this->params = new JParameter($this->plugin->params);
		}

		// Подключить, если возможно, вспомогательный класс для текущего компонента
		$this->component = JRequest::getVar('option');
		$blogFile = $this->path.DS.'mavikthumbnails'.DS.'blogs'.DS.$this->component.'.php';
		if ($this->exists($blogFile)) {
			require_once($blogFile);
			$classBlogHelper = 'plgContentMavikThumbnails'.$this->component;
			$this->blogHelper = new $classBlogHelper($this);
		}
		*/
		/*=== Определить параметры плагина ===*/
		$this->thumbPath = explode("\n", 'images/thumbnails');
		// Определить папку для иконок по умолчанию
		$countPath = count($this->thumbPath);
		for ($i=0; $i<$countPath; ++$i) {
			$thumbPath = $this->thumbPath[$i] = trim($this->thumbPath[$i]);
			if(strpos($thumbPath, ':') === FALSE) {
				$this->thumbPathDefault = $thumbPath;
				$this->thumbPath[$i] = ":$thumbPath";
			}
		}
		/*
		$this->thumbPathSubdir = $this->params->def('thumbputh_subdir', 0);
		$this->remotePath = $this->params->def('remoteputh', 'images/thumbnails/remote');
		$this->popupType = $this->params->def('popuptype', 'slimbox');
		$this->linkScripts = $this->params->def('link_scripts', 1);
		$this->blogLink = $this->params->def('blog_link', 0);
		$this->zoominImg = $this->params->def('zoomin_img', 0);
		$this->zoominCur = $this->params->def('zoomin_cur', 0);
		$this->quality = $this->params->def('quality', 80);
		$this->defaultSize = $this->params->def('default_size', '');
		$this->defaultWidth = $this->params->def('width', 0);
		$this->defaultHeight = $this->params->def('height', 0);
		$this->blogDefaultSize = $this->params->def('blog_default_size', '');
		$this->blogDefaultWidth = $this->params->def('blog_width', 0);
		$this->blogDefaultHeight = $this->params->def('blog_height', 0);
		$this->thumbnailsFor = $this->params->def('thumbnails_for', 0);
		$this->class = $this->params->def('class', '');
		*/
		
		$this->thumbPathSubdir = 1;
		$this->remotePath = 'images/thumbnails/remote';
		$this->popupType = 'fancybox';
		$this->linkScripts = 1;
		$this->blogLink = 0;
		$this->zoominImg = 0;
		$this->zoominCur = 0;
		$this->quality = 80;
		$this->defaultSize = '';
		$this->defaultWidth = 0;
		$this->defaultHeight = 0;
		$this->blogDefaultSize = '';
		$this->blogDefaultWidth = 0;
		$this->blogDefaultHeight = 0;
		$this->thumbnailsFor = 0;
		$this->class = '';
		
		/*--- Конец параметрова ---*/
		/*
		// Проверить версию PHP
		if ((version_compare(PHP_VERSION, '5.0.0', '<'))) {
			$app->enqueueMessage(JText::_('Plugin mavikThumbnails needs PHP 5. You use PHP').' '.PHP_VERSION, 'error');
		}
		*/
		// Проверить наличие библиотеки GD2
		if (!function_exists('imagecreatetruecolor')) {
			echo ('Plugin mavikThumbnails needs library GD2');
		}
		/*
		// Проверить наличие и при необходимости создать папки для изображений
		$indexFile = '<html><body bgcolor="#FFFFFF"></body></html>';
		foreach ($this->thumbPath as $thumbPath) {
			$thumbPath = substr($thumbPath, strpos($thumbPath, ':')+1);
			if (!JFolder::exists(JPATH_SITE.DS.$thumbPath)) {
				if (!JFolder::create(JPATH_SITE.DS.$thumbPath, 0777)) {
					$app->enqueueMessage(JText::_('Can\'t create directory').': '.$thumbPath, 'error');
					$app->enqueueMessage(JText::_('Change the permissions for all the folders to 777'), 'notice');
				}
				$this->write(JPATH_SITE.DS.$thumbPath.DS.'index.html', $indexFile);
			}
		}
		if (!JFolder::exists(JPATH_SITE.DS.$this->remotePath)) {
			if (!JFolder::create(JPATH_SITE.DS.$this->remotePath, 0777)) {
				$app->enqueueMessage(JText::_('Can\'t create directory').': '.$this->remotePath, 'error');
				$app->enqueueMessage(JText::_('Change the permission for all the folders to 777'), 'notice');
			}
			$this->write(JPATH_SITE.DS.$this->remotePath.DS.'index.html', $indexFile);
		}
		*/
		
		// Подключить необходимый класс декоратора	
		if ( $this->blogLink && $this->blogHelper && $this->blogHelper->isBlog() ) {
			$this->popupType = 'bloglink';
		} elseif ($this->popupType == 'none') {
			$this->popupType = '';
		}
		if($this->popupType) {
			$file = $this->path. DS . $this->popupType . '.php';
			require_once( $file );
		}
		$type = 'plgContentMavikThumbnailsDecorator' . $this->popupType;
		$this->decorator = new $type($this);
		$this->img = new plgContentMavikThumbnailsImgTag();

		// Подключить необходиму стратегию ресайзинга
		if ($this->blogHelper && $this->blogHelper->isBlog()) {
			//$proportions = $this->params->def('blog_proportions', 'keep');
			$proportions = 'keep';
		} else {
			$proportions = 'keep';
			//$proportions = $this->params->def('proportions', 'keep');
		}
		$proportinsClass = 'plgContentMavikThumbnailsProportions'.$proportions;
		require_once($this->path.DS.'proportions'.DS.$proportions.'.php');
		$this->proportionsStrategy = new $proportinsClass($this);
	}
	
	/**
	* Метод вывызываемый при просмотре в версии 1.5
	* @param 	object		Объект статьи
	* @param 	object		Параметры статьи
	* @param 	int			Номер страницы
	*/
	function onPrepareContent( &$article)
	{
		$this->article = &$article;
		//$this->articleParams =& $params;
		$this->decorator->item();
		// Найти в тексте изображения и заменить на иконки
		$regex = '#<img\s.*?>#';
		$article->text = preg_replace_callback($regex, array($this, "imageReplacer"), $article->text);
		return '';
	}

	/**
	 * Подготовка содержимого к отображению в версии 1.6
	 *
	 * @param	string		The context for the content passed to the plugin.
	 * @param	object		The content object.  Note $article->text is also available
	 * @param	object		The content params
	 * @param	int		The 'page' number
	 * @return	string
	 */
	public function onContentPrepare($context, &$article, &$params, $limitstart=0)
	{
		// Если нет id статьи, подменить заглушкой, которую затем заменить на id
		if(empty($article->id)) $article->id = '{articleID}';
		
		$this->onPrepareContent( $article, $params, $limitstart );
	}

	/**
	 * Метод вывызываемый непососредственно перед отображением контента в версии 1.6
	 * В отличии от onContentPrepare сдесь доступны все свойства контента и в режиме блога
	 * Поэтому сдесь дообрабатываются блоги
	 *
	 * @param	string		The context for the content passed to the plugin.
	 * @param	object		The content object.  Note $article->text is also available
	 * @param	object		The content params
	 * @param	int		The 'page' number
	 * @return	string
	 */
	public function onContentBeforeDisplay($context, &$article, &$params, $limitstart=0)
	{
		// Заменить заглушки {articleID} на id статьи
		$article->introtext = str_replace('{articleID}', $article->id, $article->introtext);
		
		if( $this->blogLink && $this->blogHelper && $this->blogHelper->isBlog() ) {
			// Манипуляция с text и introtext нужна для коректной работы блога
			// TODO Изучить возможность упрощения
			if (empty($article->text) && !empty($article->introtext)) {
				$myArticle = $article;
				$myArticle->text = $article->introtext;
				$this->onPrepareContent( $myArticle, $params, $limitstart );
				$article->introtext = $myArticle->text;
			}
		}
	}

	/**
	 * Преобразует img-тег в html-код иконки
	 * @param array $matches
	 * @return string
	 */
	function imageReplacer(&$matches)
	{
		// Создать объект тега изображения
		$newImgStr = $imgStr = $matches[0];
		$this->img->parse($imgStr);

		// Если указаны классы для которых (не)надо создавать иконки, проверить класс изображения.
		// И если для данного не надо создавать - выйти из функции.
		if ($this->thumbnailsFor && $this->class) {
			$imgClasses = explode(' ', $this->img->getAttribute('class'));
			$myClasses = preg_split('/\W+/', $this->class);
			$classFind = array_intersect($imgClasses, $myClasses);
			if (($this->thumbnailsFor == 1 && !$classFind) || ($this->thumbnailsFor == 2 && $classFind)) return $imgStr;
		}

		// Если изображение удаленное - проверить наличие локальной копии, при отсутствии создать
		/*
		$juri =& JFactory::getURI();
		$src = $this->img->getAttribute('src');
		if (!$juri->isInternal($src)) {
			$this->copyRemote($src);			
		}
		*/
		
		// Проверить необходимость замены - нужна ли иконка?
		// Прежде чем обращатья к функциям GD, проверяются атрибуты тега.
		if ( $this->img->getHeight() || $this->img->getWidth() || $this->defaultWidth || $this->defaultHeight )
		{
			//$this->origImgName = $this->img->getAttribute('src');
			$this->origImgName = substr($this->img->getAttribute('src'), 1);
			$this->origImgName = $this->urlToFile($this->origImgName);
				
			$this->origImgSize = @getimagesize($this->origImgName);
			//echo"<pre>";print_r($this->origImgSize);echo"</pre>";
			// Если размер файла определить не удалось, вероятно это скрипт
			// Копируем как файл с удаленного сервера и пробуем еще раз
			if($this->origImgSize === false) {
				$src = new JURI($src);
				$src->setHost($_SERVER['SERVER_NAME']);
				$src->setScheme('http');
				$this->copyRemote($src->toString());
				$this->origImgName = $this->img->getAttribute('src');
				$this->origImgName = $this->urlToFile($this->origImgName);
				$this->origImgSize = @getimagesize($this->origImgName);
			}
			$origImgW = $this->origImgSize[0];
			$this->origImgSize[1] = $this->origImgSize[1];
			
			/* Размеры по-умолчанию */
			// Если это блог или главная, взять настройки для блогов
			if ($this->blogHelper && $this->blogHelper->isBlog()) {
				$this->defaultSize = $this->blogDefaultSize;
				$this->defaultWidth = $this->blogDefaultWidth;
				$this->defaultHeight = $this->blogDefaultHeight;
			}
			$this->proportionsStrategy->setDefaultSize();

			if (( $this->img->getWidth() && $this->img->getWidth() < $this->origImgSize[0] ) || ( $this->img->getHeight() && $this->img->getHeight() < $this->origImgSize[1] ))
			{
				// Заменить изображение на иконку
				$newImgStr = $this->createThumb();
				$this->img->isThumb = true;
			}
		}
		//echo"<pre>";print_r($this->decorator);echo"</pre>";
		if ($this->img->isThumb || $this->popupType == 'bloglink') {
			//if (!$this->has_header) $this->decorator->addHeader();
			$this->has_header = true;
			$result = $this->decorator->decorate();
		} else { 
			$result = $this->img->toString(); 
		}
		return $result; 
	}
	
	/**
	 * Создает иконку, если она еще не существует.
	 */
	function createThumb()
	{
		// Доопределить размеры, если необходимо
		if ($this->img->getWidth()==0) $this->img->setWidth(intval($this->img->getHeight() * $this->origImgSize[0] / $this->origImgSize[1])); 
		if ($this->img->getHeight()==0) $this->img->setHeight(intval($this->img->getWidth() * $this->origImgSize[1] / $this->origImgSize[0]));
		// Сформировать путь к иконке
		$thumbPath = $thumbName = '';
		$this->setThumbName($thumbPath, $thumbName);
		// Если иконки не существует - создать
		if (!file_exists($thumbPath))
		{
			// Проверить хватит ли памяти
			$allocatedMemory = ini_get('memory_limit')*1048576 - memory_get_usage(true);
			$neededMemory = $this->origImgSize[0] * $this->origImgSize[1] * 4;
			$neededMemory *= 1.25; // Прибавляем 25% на накладные расходы
			if ($neededMemory >= $allocatedMemory) {
				$this->originalSrc = $this->img->getAttribute('src');
				$this->img->setAttribute('src', '');
				$app = &JFactory::getApplication();
				$app->enqueueMessage(JText::_('You use too big image'), 'error');
				return;
			}

			// Определить тип оригинального изображения
			$mime = $this->origImgSize['mime'];
			// В зависимости от этого создать объект изобразения
			switch ($mime)
			{
				case 'image/jpeg':
					$orig = imagecreatefromjpeg($this->origImgName);
					break;
				case 'image/png':
					$orig = imagecreatefrompng($this->origImgName);
					break;
				case 'image/gif':
					$orig = imagecreatefromgif($this->origImgName);
					break;
				default:
					// Если тип не поддерживается - вернуть тег без изменений
					$this->originalSrc = $this->img->getAttribute('src');
					return;
			}
			// Создать объект иконки
			$thumb = imagecreatetruecolor($this->img->getWidth(), $this->img->getHeight());
			// Обработать прозрачность
			if ($mime == 'image/png' || $mime == 'image/gif') {
				$transparent_index = imagecolortransparent($orig);
				if ($transparent_index >= 0 && $transparent_index < imagecolorstotal($orig))
				{
					// без альфа-канала
					$t_c = imagecolorsforindex($orig, $transparent_index);
					$transparent_index = imagecolorallocate($orig, $t_c['red'], $t_c['green'], $t_c['blue']);
					imagefilledrectangle( $thumb, 0, 0, $this->img->getWidth(), $this->img->getHeight(), $transparent_index );
					imagecolortransparent($thumb, $transparent_index);
				}
				if ($mime == 'image/png') {
					// с альфа-каналом
					imagealphablending ( $thumb, false );
					imagesavealpha ( $thumb, true );
					$transparent = imagecolorallocatealpha ( $thumb, 255, 255, 255, 127 );
					imagefilledrectangle( $thumb, 0, 0, $this->img->getWidth(), $this->img->getHeight(), $transparent );
				}
			}

			// Создать превью
			list($x, $y, $widht, $height) = $this->proportionsStrategy->getArea();
			imagecopyresampled($thumb, $orig, 0, 0, $x, $y, $this->img->getWidth(), $this->img->getHeight(), $widht, $height);
			// Записать иконку в файл
			switch ($mime)
			{
				case 'image/jpeg':
					if (!imagejpeg($thumb, $thumbPath, $this->quality)) {
						$this->errorCreateFile($thumbPath);
					}
					break;
				case 'image/png':
					if (!imagepng($thumb, $thumbPath)) {
						$this->errorCreateFile($thumbPath);
					}
					break;
				case 'image/gif':
					if (!imagegif($thumb, $thumbPath)) {
						$this->errorCreateFile($thumbPath);
					}
			}
			imagedestroy($orig);
			imagedestroy($thumb);
		}
		$this->originalSrc = $this->img->getAttribute('src');
		
		// Определить путь к корневой папке веб-сервера 
		// JPATH_ROOT - не совмем то, может содержать папку в которой находится сайт.
		// Изврат, но $_SERVER['DOCUMENT_ROOT'] оказался ненадежным
		$rootPath = str_replace('/', DS, Yii::getPathOfAlias('webroot'));
		//echo"<pre>";print_r($rootPath);echo"</pre>";
		/*
		$uriBase = JURI::base(true);
		if ($uriBase) $rootPath = substr($rootPath, 0, -strlen($uriBase));
		*/
		if(strpos($thumbPath, $rootPath)===0) {
		    $thumbPath = substr($thumbPath, strlen($rootPath));
		}
		$thumbPath = str_replace('\\', '/', $thumbPath);
		//echo"<pre>thumbPath - ";print_r($thumbPath);echo"</pre>";
		$this->img->setAttribute('src', $thumbPath);
	}
	
	/**
	 * Преобразует url-путь в путь к файлу
	 * если хост в url совпадает с url сайта,
	 * иначе оставляет без изменений
	 *
	 * @param string $url
	 */
	function urlToFile($url)
	{
		//$siteUri = JFactory::getURI();
		/*
		$siteUri = Yii::app()->getBaseUrl(true);
		if ($url[0] == '/')	{
			$url = $siteUri.$url;
		}
		/*
		$imgUri = JURI::getInstance($url);
		
		$siteHost = $siteUri->getHost();
		$imgHost = $imgUri->getHost();
		// игнорировать www при сверке хостов 
		$siteHost = preg_replace('/^www\./', '', $siteHost);
		$imgHost = preg_replace('/^www\./', '', $imgHost);
		if (empty($imgHost) || $imgHost == $siteHost) {
			$imgPath = $imgUri->getPath(); 
			// если путь к изображению абсолютный от корня домена (начинается со слеша),
			// преобразовать его в относительный от базового адреса сайта
			if ($imgPath[0] == '/')	{
				$siteBase = $siteUri->base();
				$dirSite = substr($siteBase, strpos($siteBase, $siteHost) + strlen($siteHost));
				$url = substr($imgPath, strlen($dirSite));
			}
			$url = urldecode(str_replace('/', DS, $url));
		}
		*/
		return $url;
	}
	
	/**
	 * Сформировать путь к иконке.
	 * При необходимости создать требуемые подпапки
	 */
	function setThumbName(&$thumbPath, &$thumbName)	
	{
		// Определить в какую папку помещать иконку
		// Определить начало относительного пути
		// если для папки изображения задана специальная папка для иконок
		$startPath = 0;
		foreach ($this->thumbPath as $path) {
			@list($dir, $path) = explode(':', $path);
			if($dir && (
				strpos($this->img->_attributes['src'], $dir) === 0 || 
				strpos($this->img->_attributes['src'], JURI::base(true).'/'.$dir) === 0 || 
				strpos($this->img->_attributes['src'], JURI::base().$dir) === 0 ) 
		) {
				$thumbPath = $path;
				$startPath = strlen($dir)+1;
			}
		}
		$thumbPath = $thumbPath ? $thumbPath : $this->thumbPathDefault;
		
		if ($this->thumbPathSubdir == 1) {
			//echo"<pre>";print_r($this->origImgName);echo"</pre>";
		    // В папке иконок формируется структура каталогов аналогичная оригинальной
		    $thumbName = $this->makeSafe($this->getName($this->origImgName));
			//echo"<pre>";print_r($thumbName);echo"</pre>";
			
		    $ext = $this->getExt($thumbName);
			//echo"<pre>";print_r($ext);echo"</pre>";
			
		    $thumbName = $this->stripExt($thumbName) . '-'.$this->img->getWidth() . 'x' . $this->img->getHeight().'.'.$ext;
			//echo"<pre>";print_r($thumbName);echo"</pre>";
			/************/
		    //$thumbPath = Yii::app()->basePath . DS . $thumbPath . DS . substr($this->origImgName, $startPath);
		    $thumbPath = Yii::getPathOfAlias('webroot') . DS . $thumbPath . DS . substr($this->origImgName, $startPath);
			//echo"<pre>";print_r($thumbPath);echo"</pre>";
			
		    $thumbPath = str_replace('\\', DS, $thumbPath);
			//echo"<pre>";print_r($thumbPath);echo"</pre>";
			
		    $thumbPath = str_replace('/', DS, $thumbPath);
			//echo"<pre>";print_r($thumbPath);echo"</pre>";
			
		    $path = substr($thumbPath, 0, strrpos($thumbPath, DS));
			//echo"<pre>";print_r($path);echo"</pre>";
			
		    if(!$this->folderExists($path)) {
				//echo"<pre>";print_r($path);echo"</pre>";
				//JFolder::create($path, 0777);
				mkdir($path, 0777, true);
				$indexFile = '<html><body bgcolor="#FFFFFF"></body></html>';
				//JFile::write($path.DS.'index.html', $indexFile);
				
				$fp = fopen($path.DS.'index.html', "a"); // Открываем файл в режиме записи
				$mytext = "Это строку необходимо нам записать\r\n"; // Исходная строка
				$test = fwrite($fp, $indexFile); // Запись в файл
				//if ($test) echo 'Данные в файл успешно занесены.';
				//else echo 'Ошибка при записи в файл.';
				fclose($fp); //Закрытие файла		
				
		    }
		    $thumbPath = $path . DS . $thumbName;
		} else {
		    // Все иконки складываются в одну папку
		    // Перед "защитой" имени заменить слеши на "-" для сохрания читабельности
		    $thumbName = $this->makeSafe(str_replace(array('/','\\'), '-', $this->origImgName));
		    $thumbName = $this->stripExt($thumbName) . '-'.$this->img->getWidth() . 'x' . $this->img->getHeight().'.'.$this->getExt($thumbName);
		    $thumbPath = Yii::app()->basePath . DS . $thumbPath . DS . $thumbName; 	    
		}
	}
	
	/**
	 * Копировать файл с другого сервера
	 * @param string $src URL файла
	 */
	function copyRemote($src)
	{
		// Перед "защитой" имени заменить слеши на "-" для сохрания читабельности
		$fileName = $this->makeSafe(str_replace(array('/','\\'), '-', $src));
		$localFile = $this->remotePath . DS . $fileName; 
		if (!file_exists($localFile)) {
			//$this->copy($src, $localFile); // Родная функция не работает с url
			copy(html_entity_decode($src), $localFile);
		}
		$this->img->setAttribute('src', $this->remotePath . '/' . $fileName);
	}

	/**
	 * Сообщение о невозможности создать файл
	 * @param string $file
	 */
	function errorCreateFile($file) 
	{
		$app =& JFactory::getApplication();
		$msg = sprintf(JText::_('Can\'t create file %s. Change the permissions for folder %s to 777.'), $file, dirname($file));
		$app->enqueueMessage($msg, 'error');
	}
	
	/**
	 * Gets the extension of a file name
	 *
	 * @param   string  $file  The file name
	 *
	 * @return  string  The file extension
	 *
	 */
	public static function getExt($file)
	{
		$dot = strrpos($file, '.') + 1;

		return substr($file, $dot);
	}

	/**
	 * Strips the last extension off of a file name
	 *
	 * @param   string  $file  The file name
	 *
	 * @return  string  The file name without the extension
	 *
	 */
	public static function stripExt($file)
	{
		return preg_replace('#\.[^.]*$#', '', $file);
	}
	
	
	/**
	 * Makes file name safe to use
	 *
	 * @param   string  $file  The name of the file [not full path]
	 *
	 * @return  string  The sanitised string
	 *
	 */
	public static function makeSafe($file)
	{
		$regex = array('#(\.){2,}#', '#[^A-Za-z0-9\.\_\- ]#', '#^\.#');

		return preg_replace($regex, '', $file);
	}
	/**
	
	 * Returns the name, without any path.
	 *
	 * @param   string  $file  File path
	 *
	 * @return  string  filename
	 *
	 */
	public static function getName($file)
	{
		// Convert back slashes to forward slashes
		$file = str_replace('\\', '/', $file);
		$slash = strrpos($file, '/');
		if ($slash !== false)
		{

			return substr($file, $slash + 1);
		}
		else
		{

			return $file;
		}
	}
	
	/**
	 * Wrapper for the standard file_exists function
	 *
	 * @param   string  $file  File path
	 *
	 * @return  boolean  True if path is a file
	 *
	 * @since   11.1
	 */
	public function fileExists($file)
	{
		return is_file($this->pathClean($file));
	}
	
	public function folderExists($path)
	{
		//print_r($path);
		return is_dir($this->pathClean($path));
	}
	
	/**
	 * Function to strip additional / or \ in a path name.
	 *
	 * @param   string  $path  The path to clean.
	 * @param   string  $ds    Directory separator (optional).
	 *
	 * @return  string  The cleaned path.
	 *
	 * @since   11.1
	 */
	public static function pathClean($path, $ds = DIRECTORY_SEPARATOR)
	{
		$path = trim($path);

		if (empty($path))
		{
			$path = JPATH_ROOT;
		}
		else
		{
			// Remove double slashes and backslashes and convert all slashes and backslashes to DIRECTORY_SEPARATOR
			$path = preg_replace('#[/\\\\]+#', $ds, $path);
		}

		return $path;
	}
}

/**
 * Декорирование тега изображения: всплывающие окна и т.п.
 * Родительский клас
 */
class plgContentMavikThumbnailsDecorator
{
	/**
	 * Ссылка на объект плагина
	 * @var plgContentMavikThumbnails 
	 */
	var $plugin;
	
	/**
	 * Конструктор
	 * @param $plugin
	 */
	function plgContentMavikThumbnailsDecorator(&$plugin)
	{
		$this->plugin = $plugin;
	}
	
	/**
	 * Добавление кода в заголовок страницы 
	 */
	function addHeader() {}

	/**
	 * Действия выполняемые для каждой статьи
	 */
	function item() {}

	/**
	 * Декорирование тега изображения
	 * @return string Декорированый тег изображения
	 */
	function decorate()
	{
		$img =& $this->plugin->img;
		return $img->toString();
	}
}

/**
 * Стратегия поведения зависящая от метода ресайзинга
 * Родительский клас
 */
class plgContentMavikThumbnailsProportions
{
	/**
	 * Ссылка на объект плагина
	 * @var plgContentMavikThumbnails
	 */
	var $plugin;

	/**
	 * Конструктор
	 * @param $plugin
	 */
	function  __construct(&$pligin)
	{
		$this->plugin =& $pligin;
	}

	/**
	 * Установка для превьюшки размера заданого по умолчанию.
	 * В большинстве случает не требует переопределения.
	 * Изменение поведения лучше изменять замещая метод getDefaultDimension
	 */
	function setDefaultSize()
	{
			$plugin = &$this->plugin;

			if (
				 ( $plugin->defaultSize == 'all' && ($plugin->defaultHeight || $plugin->defaultWidth)) ||
				 ( $plugin->defaultSize == 'not_resized' && ((!$plugin->img->getWidth() || $plugin->img->getWidth() == $plugin->origImgSize[0]) && (!$plugin->img->getHeight() || $plugin->img->getHeight() == $plugin->origImgSize[1])))
				) {
				// Определить какой дефолтный размер использовать, высоту или ширину
				$defoultSize = '';
				if (!$plugin->defaultHeight && $plugin->defaultWidth && $plugin->defaultWidth < $plugin->origImgSize[0]) {
					// Умолчание задано только для ширины
					$defoultSize = 'w';
				} elseif (!$plugin->defaultWidth && $plugin->defaultHeight && $plugin->defaultHeight < $plugin->origImgSize[1]) {
					// Умолчание задано только для высоты
					$defoultSize = 'h';
				} elseif ($plugin->defaultWidth && $plugin->defaultHeight && ($plugin->defaultWidth < $plugin->origImgSize[0] || $plugin->defaultHeight < $plugin->origImgSize[1])) {
					// Заданы оба размера, определить какой использовать, чтобы вписать в размеры
					$defoultSize = $this->getDefaultDimension();
				}

				// Применить размеры
				if ($defoultSize == 'w') {
					$plugin->img->setWidth(intval($plugin->defaultWidth));
					$plugin->img->setHeight($plugin->origImgSize[1] * $plugin->defaultWidth/$plugin->origImgSize[0]);
				} elseif ($defoultSize == 'h') {
					$plugin->img->setHeight(intval($plugin->defaultHeight));
					$plugin->img->setWidth($plugin->origImgSize[0] * $plugin->defaultHeight/$plugin->origImgSize[1]);
				} elseif ($defoultSize == 'wh') {
					$plugin->img->setHeight(intval($plugin->defaultHeight));
					$plugin->img->setWidth(intval($plugin->defaultWidth));
				}
			}
	}

	/**
	 * Выбор вертикально (h), горизонтального (w) либо обоих (wh) дефолтных размеров
	 * @return string
	 */
	function getDefaultDimension()
	{
		return 'wh';
	}

	/**
	 * Возвращает координаты и размер используемой в оригинальном ибображении области
	 * @return array
	 */
	function getArea()
	{
		return array(0, 0, $this->plugin->origImgSize[0], $this->plugin->origImgSize[1]);
	}
}
