<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CategoryRepository;
use App\Repositories\TldRepository;
use App\Repositories\LanguageRepository;
use App\Repositories\CartRepository;
use App\Repositories\WebsiteRepository;
use App\Http\Controllers\AppBaseController;
use Flash;
use Response;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Language;
use App\Models\Tld;
use App\Models\Website;
use Illuminate\Support\Facades\DB;

class BuyController extends AppBaseController
{
	/** @var  CategoryRepository */
    private $categoryRepository;

    private $tldRepository;

    private $languageRepository;

    private $cartRepository;

    private $websiteRepository;

    public $slugs = [];
    public $cateslug = [];

    public function __construct(CategoryRepository $categoryRepo, TldRepository $tldRepo, LanguageRepository $languageRepo, CartRepository $cartRepo, WebsiteRepository $websiteRepository)
    {
        $this->categoryRepository = $categoryRepo;
        $this->tldRepository = $tldRepo;
        $this->languageRepository = $languageRepo;
        $this->cartRepository = $cartRepo;
        $this->websiteRepository = $websiteRepository;
    }

	public function index() {
		$categories = $this->categoryRepository->all();

		$slugs = $this->slugs;

		foreach ($categories as $category) {
			//array_push($slugs, strtolower(preg_replace('/[^A-Za-z0-9]+/', '-', $category->name)));

            array_push($slugs, strtolower(strtr($category->name, " ", "-")));

            //array_push($slugs, $category->name);
        }
        
        $tlds = $this->tldRepository->all();

        $languages = $this->languageRepository->all();

		return view('pages.marketplace')->with('categories', $categories)->with('slugs', $slugs)->with('tlds', $tlds)->with('languages', $languages);
	}

    public function show($categories) {
        $cateslug = ucwords(strtr($categories, "-", " "));
        
        $catego = $categories;

    	$categories = $this->categoryRepository->all();

    	$tlds = $this->tldRepository->all();

        $languages = $this->languageRepository->all();
        
        $websites2 = [];

    	return view('buy.index')->with('cateslug', $cateslug)->with('categories', $categories)->with('tlds', $tlds)->with('languages', $languages)->with('websites2', $websites2)->with('catego', $catego);
    }

    public function marketplace(Request $request){

        if ($request->categories == 'All') {
            # code...
        }
        
        $tld = Tld::where('name', $request->tlds)->first();

        $language = Language::where('name', $request->languages)->first();

        $cateslug = Category::where('name', $request->categories)->first();

        $websites2 = Website::join('link_types', 'link_types.id', '=', 'websites.link_type_id')
                        ->join('post_contents', 'post_contents.id', '=', 'websites.post_content_id')
                        ->join('category_website', 'category_website.website_id', '=', 'websites.id')
                        ->join('categories', 'categories.id', '=', 'category_website.category_id')
                        ->where('websites.tld_id', $tld->id)
                        ->where('websites.language_id', $language->id)
                        ->where('categories.id', $cateslug->id)
                        ->select('websites.name as web_name', 'websites.domain_authority as da', 'websites.page_authority as pa', 'websites.price as price', 'link_types.name as link_type', 'post_contents.name as post_content', 'categories.name as category')
                        ->orderBy('websites.id', 'desc')
                        ->get();

        $cateslug = $cateslug->name;

    	$categories = $this->categoryRepository->all();

    	$tlds = $this->tldRepository->all();

        $languages = $this->languageRepository->all();
        
        $catego = '';

    	return view('buy.index')->with('cateslug', $cateslug)->with('categories', $categories)->with('tlds', $tlds)->with('languages', $languages)->with('websites2', $websites2)->with('catego', $catego);
    }

    public function cart() {
        $carts = Cart::where('user_id', auth()->user()->id)
                            ->orderBy('id', 'desc')
                            ->get();

        if (sizeof($carts) == 0) {

            $categories = $this->categoryRepository->all();

		    $slugs = $this->slugs;

		    foreach ($categories as $category) {

                array_push($slugs, strtolower(strtr($category->name, " ", "-")));
		    }

		    return view('pages.marketplace')->with('categories', $categories)->with('slugs', $slugs);

        } else {

            $websites = [];
            $precioTotal = 0;
            foreach ($carts as $cart) {
                $web = Website::where('id', $cart->website_id)->first();
                $precioTotal = $precioTotal + $web->price;
                array_push($websites, $web);
            }
    
            return view('buy.cart')->with('cart', $cart)->with('websites', $websites)->with('precioTotal', $precioTotal);
        }

    }
}
