<?php
namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;
use File;
use App\Http\Models\Sites;
use App\Http\Models\Users;
use App\Http\Models\Pages;
use App\Helpers\Path;

class SiteController extends BaseController
{
    public function createPage (Request $request,$id)
    {
        $page = $request->all();
        $site = Sites::find($id);
        $page = new Pages($page);
        $page->site()->associate($site);
        $page->save();
        return response()->json($page);
    } 
    
    public function uploadBannerImage(Request $request)
    {
        $userId = Authorizer::getResourceOwnerId();
        $file = $request->file('image');
        $file->move(
            Path::public_path('image/'.$userId), 
            'banner.'.$file->getClientOriginalExtension()
        );
        return response()->json('success');
    }

    public function render(Request $request,$id,$slug = 'home')
    {
        $user = Users::with(['site','pages'])->find($id);
        $page = $user->pages()->where('slug', 'home')->get()->toArray();
        $user = $user->toArray();
        $data = array(
            'name' => $user['site']['name'],
            'id' => $user['id'],
            'css' => '/css/'.$user['site']['css'].'.css',
            'bannerimage' => $this->getBannerImage($id),
            'navigation' => array_column($user['pages'], 'title','slug'),
            'page' => $page[0]
        );
        return view('sites.render', $data);
    }

    private function getBannerImage($id)
    {
        $dirname = Path::public_path('image/'.$id);
        $images = glob($dirname."/banner.*");

        return str_replace('/app/public', '', $images[0]);
    }
}