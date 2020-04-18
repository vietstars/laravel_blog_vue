<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;
use Auth;
use Image;

class PostController extends Controller
{
    public function all_post()
    {
    	$posts = Post::with('user','category')->get();
    	return response()->json(array('posts' => $posts),200);
    }

    public function add_post(Request $request)
    {
        $this->validate($request,array(
            'category_id'=>'required|min:1|max:11',
            'post_title' =>'required|min:2|max:50',
            'post_description' => 'required|min:2|max:50'
        ));
        // $strpos = strpos($request->post_photo,';');
        // $sub = substr($request->post_photo,0,$strpos);
        // $ex = explode('/',$sub)[1];
        $post = new Post();

        if( $request->post_photo )
        {
            $photo_name = time()."_".$request->photo_name;
            $img = Image::make($request->post_photo);//->resize(400, 400);
            
            if(!is_dir(public_path()."/img/post/post_".$request->category_id))
            {   
                if(!is_dir(public_path()."/img/post"))
                {
                    if(!is_dir(public_path()."/img"))
                    {
                        mkdir(public_path()."/img");
                        chmod(public_path()."/img", 777);                
                    }
                    mkdir(public_path()."/img/post");
                    chmod(public_path()."/img/post", 777);
                }
                mkdir(public_path()."/img/post/post_".$request->category_id);
                chmod(public_path()."/img/post/post_".$request->category_id, 777);
            }
            $upload_path = public_path()."/img/post/post_".$request->category_id.'/';
            $img->save($upload_path.$photo_name);
            if( file_exists($upload_path.$photo_name) )
            {
                $post->photo = $photo_name;
            }
        }elseif( $request->photo_name && str_replace('http','',$request->photo_name)!=$request->photo_name)
        {
            $post->photo = $request->photo_name;
        }
        $post->category_id = $request->category_id;
        $post->user_id = Auth::user()->id;
        $post->title = $request->post_title;
        $post->description = $request->post_description;
        $post->save();
        if( $request->post_photo )
        {
            rename($upload_path,public_path()."/img/post/post_".$post->id);
        }
        return array('message'=>'OK');
    }

    public function update_post(Request $request)
    {
        $this->validate($request,array(
            'post_id'=>'required|min:1|max:11',
            'category_id'=>'required|min:1|max:11',
            'post_title' =>'required|min:2|max:50',
            'post_description' => 'required|min:2|max:50'
        ));
        $post = Post::find($request->post_id);

        if( $request->post_photo )
        {
            $photo_name = time()."_".$request->photo_name;
            $img = Image::make($request->post_photo);//->resize(400, 400);
            if(!is_dir(public_path()."/img/post/post_".$request->post_id))
            {   
                if(!is_dir(public_path()."/img/post"))
                {
                    if(!is_dir(public_path()."/img"))
                    {
                        mkdir(public_path()."/img");
                        chmod(public_path()."/img", 777);                
                    }
                    mkdir(public_path()."/img/post");
                    chmod(public_path()."/img/post", 777);
                }
                mkdir(public_path()."/img/post/post_".$request->post_id);
                chmod(public_path()."/img/post/post_".$request->post_id, 777);
            }
            $upload_path = public_path()."/img/post/post_".$request->post_id.'/';
            $img->save($upload_path.$photo_name);
            if( file_exists($upload_path.$photo_name) )
            {
                $post->photo = $photo_name;
            }
        }elseif( $request->photo_name && str_replace('http','',$request->photo_name)!=$request->photo_name)
        {
            $post->photo = $request->photo_name;
        }
        $post->category_id = $request->category_id;
        $post->user_id = Auth::user()->id;
        $post->title = $request->post_title;
        $post->description = $request->post_description;
        $post->save();
        return array('message'=>'OK');
    }

    public function remove_post($id)
    {
    	$post = Post::find($id);
    	$post->delete();
    	return array('message'=>'OK');
    }
}
