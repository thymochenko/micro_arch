
/** 
* Example of file-based template usage.  This uses two templates. 
* Notice that the $bdy object is assigned directly to a $tpl var. 
* The template system has built in a method for automatically 
* calling the fetch() method of a passed in template. 
*/ 
$tpl = & new Template (); 
$tpl -> set ( 'title' , 'My Test Page' ); 
$tpl -> set ( 'intro' , 'The intro paragraph.' ); 
$tpl -> set ( 'list' , array( 'cat' , 'dog' , 'mouse' )); 

$bdy = & new Template ( 'body.tpl' ); 
$bdy -> set ( 'title' , 'My Body' ); 
$bdy -> set ( 'footer' , 'My Footer' ); 

$tpl -> set ( 'body' , $bdy ); 

echo $tpl -> fetch ( 'index.tpl' ); 


/** 
* Example of cached template usage.  Doesn't provide any speed increase since 
* we're not getting information from multiple files or a database, but it 
* introduces how the is_cached() method works. 
*/ 

/** 
* Define the template file we will be using for this page. 
*/ 
$file = 'index.tpl' ; 

/** 
* Pass a unique string for the template we want to cache.  The template 
* file name + the server REQUEST_URI is a good choice because: 
*    1. If you pass just the file name, re-used templates will all 
*       get the same cache.  This is not the desired behavior. 
*    2. If you just pass the REQUEST_URI, and if you are using multiple 
*       templates per page, the templates, even though they are completely 
*       different, will share a cache file (the cache file names are based 
*       on the passed-in cache_id. 
*/ 
$tpl = & new CachedTemplate ( $file . $_SERVER [ 'REQUEST_URI' ]); 

/** 
* Test to see if the template has been cached.  If it has, we don't 
* need to do any processing.  Thus, if you put a lot of db calls in 
* here (or file reads, or anything processor/disk/db intensive), you 
* will significantly cut the amount of time it takes for a page to 
* process. 
*/ 
if(!( $tpl -> is_cached ())) { 
$tpl -> set ( 'title' , 'My Title' ); 
$tpl -> set ( 'intro' , 'The intro paragraph.' ); 
$tpl -> set ( 'list' , array( 'cat' , 'dog' , 'mouse' )); 
} 

/** 
* Fetch the cached template.  It doesn't matter if is_cached() succeeds 
* or fails - fetch_cache() will fetch a cache if it exists, but if not, 
* it will parse and return the template as usual (and make a cache for 
* next time). 
*/ 
echo $tpl -> fetch_cache ( $file ); 







public function findFkPostforCatAdminT($template) {
		 //abre transação
	    TTransaction::open();
	   //sql
		$sql='
		SELECT posts.id, posts_title, posts_autor, posts_tags, posts_text, posts_date, category.category_name, COUNT( * ) 
        FROM posts, category, comments
        WHERE posts.fk_cat_id = category.id
        AND comments.fk_posts_id = posts.id
        GROUP BY posts.id';
		//objeto categoryRecord
	    $posts=new postsRecord();
		$p= $posts->findBySql($sql);
		
		$path = TURL::BASE;
		$tplObject = "{$path}/protected/views/views.posts/{$template}";
		
        $tpl = new Template ($tplObject);
		// this is the outer template 
        $tpl->set('posts' , $p); 
        echo $tpl -> fetch ($tplObject); 
		//fecha transaçã
		TTransaction::close();
		return NULL;	
	}