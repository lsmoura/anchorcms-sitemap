/**
 * Site Maps
 * Add the snippet below to anchor/routes/site.php,
 * somewhere before the "View Pages" comment.
 *
 * Check back on this repository for any updates.
 * I'll create a plugin as soon as the plugin api is available.
 *
 * This was tested and is working on AnchorCMS 0.9.2.
 * Here's a taste: http://moura.us/sitemap.xml
 */
Route::get('sitemap.xml', function() {
  $sitemap  = '<?xml version="1.0" encoding="UTF-8"?>';
  $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

  // Main page
  $sitemap .= '<url>';
  $sitemap .= '<loc>' . Uri::full(Registry::get('posts_page')->slug . '/') . '</loc>';
  $sitemap .= '<changefreq>daily</changefreq>';
  $sitemap .= '<priority>0.8</priority>';
  $sitemap .= '</url>';

  $query = Post::where('status', '=', 'published')->sort(Base::table('posts.created'), 'desc');
  foreach($query->get() as $article) {
    $sitemap .= '<url>';
    $sitemap .= '<loc>' . Uri::full(Registry::get('posts_page')->slug . '/' . $article->slug) . '</loc>';
    $sitemap .= '<lastmod>' . date("Y-m-d", strtotime($article->created)) . '</lastmod>';
    $sitemap .= '</url>';
  }

  $sitemap .= '</urlset>';
  
  return Response::create($sitemap, 200, array('content-type' => 'application/xml'));
});
