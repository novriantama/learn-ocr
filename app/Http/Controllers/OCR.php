<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use GoogleCloudVision\GoogleCloudVision;
use GoogleCloudVision\Request\AnnotateImageRequest;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;

use App\Models\OcrModel;
use App\Models\FilesModel;


class OCR extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    public function displayForm(){
        return view('annotate');
    }

    public function annotateImage(Request $request){
        

        if ($request->hasFile('image')) {
            $name = $request->file('image')->getClientOriginalName();
            $request->image->storeAs('/public', $name);
            $url = 'storage/'.$name;
            
            $file = FilesModel::create([
                 'url' => $url
             ]);

             return view('home', compact('url'));
        }
        abort(500, 'Could not upload image :(');


        // $imageAnnotator = new ImageAnnotatorClient();

        // $fileName = url('/dist/img/wakeupcat.jpg');

        // $image = file_get_contents($request->file('image'));

        // # performs label detection on the image file
        // $response = $imageAnnotator->documentTextDetection($image);
        // $texts = $response->getFullTextAnnotation();
        // $texts->getText();
        // $imageAnnotator->close();
    }

    public function cropImage(Request $request)
    {
        
        $requestData = $request->only([
            'items',
            'url'
        ]);
        $requestData['items'] = json_decode($requestData['items']);
        
        $counter = OcrModel::orderBy('kode','desc')->pluck('kode')->first();
        $id = 1;
        $counter = $counter + 1;


        foreach($requestData['items'] as $item){
            $img = Image::make($requestData['url'])
                            ->crop($item->width, $item->height, $item->x, $item->y)
                            ->save('img/'.$id.'_'.$counter.'.jpg');
            $location = 'img/'.$id.'_'.$counter.'.jpg';
            $id = $id + 1;
            OcrModel::create([
                'kode' => $counter,
                'x' => $item->x,
                'y' => $item->y,
                'width' => $item->width,
                'height' => $item->height,
                'location' => $location
            ]);
        }

        $data = OcrModel::where('kode', '=', $counter)->get();
        $textData = [];
        foreach ($data as $item) {
            $path = $item->location;
            $imageAnnotator = new ImageAnnotatorClient();
    
            $fileName = url($item->location);
    
            $image = file_get_contents($path);
    
            # performs label detection on the image file
            
            $response = $imageAnnotator->documentTextDetection($image);
            $texts = $response->getFullTextAnnotation();
            $text = $texts->getText();
            array_push($textData, $text);
            $imageAnnotator->close();
        }
        dd($textData);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
