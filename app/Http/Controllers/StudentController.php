<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Students;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\ValidationRule as ValidationValidationRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Validation\Rule as ValidationRule;
use Intervention\Image\Laravel\Facades\Image;

class StudentController extends Controller
{
    public function index()
    {
        // $data = Students::where('age', '>', 19)->orderBy('f_name','desc')->limit(5)->get();

        // $data = DB::table('students')
        //         ->select(DB::raw('count(*) as gender_count, gender'))->groupBy('gender')->get();

        // $data = Students::where('id',100)->firstOrFail()->get();
        
        //gives data to the index.blade.php for displaying content
        
        $data = array("students" => DB::table('students')->orderBy('created_at','desc')->paginate(10));
        return view('students.index', $data);
    }

    public function show($id){
        $data = Students::findOrFail($id);
        return view('students.edit', ['student' => $data]);
    }

    public function create(){

        return view('students.create')->with('title', 'Add New');
    }

    public function store(Request $request){
        $validated = $request->validate([
            "f_name" => ['required', 'min:4'],
            "l_name" => ['required', 'min:4'],
            "gender" => ['required'],
            "age" => ['required'],
            "email" => ['required', 'email', ValidationRule::unique('students', 'email')],
        ]);

        if($request->hasFile('student_image')){
            $request->validate([
                "student_image" => 'mimes:jpeg,png,pmp,tiff | max:4096'
            ]);

            $filenameWithExtension = $request->file("student_image");

            $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);

            $extension = $request->file("student_image")
            ->getClientOriginalExtension();

            $filenameToStore = $filename .'_'.time().'.'.$extension;

            $smallThumbnail = $filename .'_'.time().'.'.$extension;

            $request->file('student_image')->storeAs('public/student', $filenameToStore);
            $request->file('student_image')->storeAs('public/student/thumbnail', $smallThumbnail);

            $thumbNail = 'storage/student/thumbnail/'.$smallThumbnail;

            $this->createThumbnail($thumbNail, 150, 93);

            $validated['student_image'] = $filenameToStore;
        }

        Students::create($validated);

        return redirect('/')->with('message','New Student was added sucessfully!');
    }

    public function update(Request $request, Students $student){
        
        $validated = $request->validate([
            "f_name" => ['required'],
            "l_name" => ['required'],
            "gender" => ['required'],
            "age" => ['required'],
            "email" => ['required', 'email'],
        ]);
       
        // dd($request);

        if($request->hasFile('student_image')){
            $request->validate([
                "student_image" => 'mimes:jpeg,png,pmp,tiff | max:4096'
            ]);

            $filenameWithExtension = $request->file("student_image");

            $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);

            $extension = $request->file("student_image")
            ->getClientOriginalExtension();

            $filenameToStore = $filename .'_'.time().'.'.$extension;

            $smallThumbnail = $filename .'_'.time().'.'.$extension;

            $request->file('student_image')->storeAs('public/student', $filenameToStore);
            $request->file('student_image')->storeAs('public/student/thumbnail', $smallThumbnail);

            $thumbNail = 'storage/student/thumbnail/'.$smallThumbnail;

            $this->createThumbnail($thumbNail, 150, 93);

            $validated['student_image'] = $filenameToStore;
        }
    
        $student->update($validated);

        return back()->with('message','Data was sucessfully updated');
    }   

    public function destroy(Students $student){
        $student->delete();
        return redirect('/')->with('message','Data was sucessfully deleted');
    }

    public function createThumbnail($path, $width, $height)
    {
        $img = Image::read($path)->resize($width, $height,
        function($contstraint){
            $contstraint->aspectRatio();
        });
        $img->save($path);
    }

}
