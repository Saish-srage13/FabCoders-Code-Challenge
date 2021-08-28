<?php

namespace App\Http\Controllers\Shared;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Libraries\Layout;
use App\Libraries\Sort;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $layout;

    protected $breadcrumbs;
    
    protected $module;

    public function __construct() 
    {
        $layout = new Layout();
        $this->layout = $layout;
    }

    protected function buildSorting($baseUrl, $default_sort = null, $default_sort_asc = null, $ignoreParams = [])
    {
        if ($this->request->has('sort')) {
            $sort = $this->request->get('sort');
            $sort_asc = $this->request->get('sort_asc', null, null);
        } else {
            $sort = $default_sort;
            $sort_asc = $default_sort_asc;
        }
        $ignoreParams = array_merge(['sort', 'sort_asc', 'page'], $ignoreParams ?: []);
        
        $sortBaseUrl = $this->appendCurrentQuery($baseUrl, $ignoreParams);
        
        $sortPlugin = new Sort($sortBaseUrl, $sort, $sort_asc);
        
        return $sortPlugin;
    }

    public function appendCurrentQuery($url, $exclude = [], $include = []) 
    {
        $exclude = array_merge($exclude ?: [], ['_url']);
        
        $getParams = [];
        if ($include) $getParams = array_intersect_key($getParams, array_combine($include, $include));
        if ($exclude) $getParams = array_diff_key($getParams, array_combine($exclude, $exclude));
        if ($getParams) $url .= (strstr($url, '?') ? '&' : '') . ($getParams ? '?' . http_build_query($getParams) : '');
        
        return $url;
    }

    public function uploadImage($image, $imageName)
    {
        $extension = $image->getClientOriginalExtension();
        $imageName = $imageName ? Str::slug($imageName) . '-' . time() : time();
        $imageFullName = $imageName . '.' . $extension;
        
        $imageFile = File::get($image);
        $localPath = Storage::disk('local')->put('movie/' . $imageFullName, $imageFile);
        
        if ($localPath) {
            return $imageFullName;
        }

        return null;
    }

}
