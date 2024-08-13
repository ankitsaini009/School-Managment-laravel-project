<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Certificate;
use App\Models\Student;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\File;
use App\Models\ReleasedCertificate;
use App\Models\Addtext;

class ReleaseCertificatesController extends Controller
{
    public function genratecertificate(Request $request){
        $validated = $request->validate([
            'certificate_id' => 'required',
            'student_id' => 'required',
            'name_x_position' => 'required',
            'name_y_position' => 'required',
            'student_discription' => 'required',
            'discrip_x_position' => 'required',
            'discrip_y_position' => 'required',
            'line_length' => 'required',
            'release_date' => 'required',
            'discription_fontsize' => 'required',
            'name_color' => 'required',
        ]);
        $certificate = Certificate::find($request->certificate_id);
        $student = Student::find($request->student_id);
        // Load the certificate template image
        $template = public_path('storage/certificates/' . $certificate->certificate_temp_path);
        // Create an instance of Intervention Image
        if (!is_null($certificate->discription_font_path)) {
            $font = public_path('storage/certificates/font/' . $certificate->discription_font_path);
        } else {
            $font = public_path('storage/certificates/font/'. $certificate->name_font_path);
        }
        $image = ImageManager::gd()->read($template);
        if (!is_null($request->student_discription)) {
            $this->addLongText($image, $request->student_discription, $request->discrip_x_position, $request->discrip_y_position, $font, $request->discription_fontsize, $certificate->discription_color, $request->line_length);
        }
        if (!is_null($request->text_data)){
            foreach ($request->text_data as $key => $value) {
                if ($request->text_font_file[$key] == 'name_font') {
                    $text_font = $certificate->name_font_path;
                    $text_color = $request->name_color;
                } else {
                    $text_font = $certificate->discription_font_path;
                    $text_color = $certificate->discription_color;
                }
                 $this->addText($image, $value,$request->text_x_position[$key], $request->text_y_position[$key],$text_font, $request->text_font_size[$key], $text_color);
            }
        }
        $this->addText($image, ucwords($student->name), $request->name_x_position, $request->name_y_position, $certificate->name_font_path, $request->name_fontsize, $request->name_color);

        $filename = 'Character_Certificate_' . $student->id . '_' . rand() . '.jpg';
        $directory = public_path('storage/releasecertificates');
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true); // Create directory recursively with permissions
        }

        $image->save(public_path('storage/releasecertificates/' . $filename));
        $image_url = asset('storage/releasecertificates/' . $filename);
        return response()->json([
            'image_url' => $image_url,
            'image_name'=>$filename,
        ]);
    }


    public function releasecertificate(Request $request)
     {
        $validated = $request->validate([
            'certificate_id' => 'required',
            'student_id' => 'required',
            'name_x_position' => 'required',
            'name_y_position' => 'required',
            'student_discription' => 'required',
            'discrip_x_position' => 'required',
            'discrip_y_position' => 'required',
            'line_length' => 'required',
            'release_date' => 'required',
            'discription_fontsize' => 'required',
            'name_color' => 'required',
        ]);
        $certificate = Certificate::find($request->certificate_id);
        $student = Student::find($request->student_id);
        // Load the certificate template image
        $template = public_path('storage/certificates/' . $certificate->certificate_temp_path);
        // Create an instance of Intervention Image
        if (!is_null($certificate->discription_font_path)) {
            $font = public_path('storage/certificates/font/' . $certificate->discription_font_path);
        } else {
            $font = public_path('storage/certificates/font/'. $certificate->name_font_path);
        }
        $image = ImageManager::gd()->read($template);
        if (!is_null($request->student_discription)) {
            $this->addLongText($image, $request->student_discription, $request->discrip_x_position, $request->discrip_y_position, $font, $request->discription_fontsize, $certificate->discription_color, $request->line_length);
        }
        if (!is_null($request->text_data)) {
            foreach ($request->text_data as $key => $value) {
                if (Addtext::where('text', $value)->where('holder_id', $request->student_id)->exists()){
                    $textdata = Addtext::where('text', $value)->first();
                    $textdata->text = $value;
                    $textdata->holder_id = $request->student_id;
                    $textdata->text_x_position = $request->text_x_position[$key];
                    $textdata->text_y_position = $request->text_y_position[$key];
                    $textdata->text_font_size = $request->text_font_size[$key];
                    if ($request->text_font_file[$key] == 'name_font') {
                        $textdata->text_font_file = $certificate->name_font_path;
                        $textdata->text_color = $request->name_color;
                    } else {
                        $textdata->text_font_file = $certificate->discription_font_path;
                        $textdata->text_color = $certificate->discription_color;
                    }
                    $textdata->save();
                } else{
                        $textdata = new Addtext;
                        $textdata->text = $value;
                        $textdata->holder_id = $request->student_id;
                        $textdata->text_x_position = $request->text_x_position[$key];
                        $textdata->text_y_position = $request->text_y_position[$key];
                        $textdata->text_font_size = $request->text_font_size[$key];
                        if ($request->text_font_file[$key] == 'name_font') {
                            $textdata->text_font_file = 'name_font';
                            $textdata->text_color = $request->name_color;
                        } else {
                            $textdata->text_font_file = 'discription_font';
                            $textdata->text_color = $certificate->discription_color;
                        }
                        $textdata->save();
                }
            }
        }
        $this->addText($image, ucwords($student->name), $request->name_x_position, $request->name_y_position, $certificate->name_font_path, $request->name_fontsize, $request->name_color);

        $addedtexts = Addtext::where('holder_id',$request->student_id)->get();
        foreach($addedtexts as $addtext){
            if ($addtext->text_font_file == 'name_font') {
               $font = $certificate->name_font_path;
            } else {
                $font = $certificate->discription_font_path;
            }
            $this->addText($image, $addtext->text, $addtext->text_x_position, $addtext->text_y_position,$font, $addtext->text_font_size, $addtext->text_color);
        }

        $filename = 'Character_Certificate_' . $student->id . '_' . rand() . '.jpg';
        $directory = public_path('storage/releasecertificates');
        // Check if the directory exists, if not, create it
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true); // Create directory recursively with permissions
        }

        if(isset($request->old_image) && !empty($request->old_image)){
            if (File::exists('storage/releasecertificates/' . $request->old_image)) {
                File::delete("storage/releasecertificates/" . $request->old_image);
            }
        }
        if (ReleasedCertificate::where('holder_id', $student->id)->exists()) {
            $releasecertificate = ReleasedCertificate::where('holder_id', $student->id)->first();
            if (File::exists('storage/releasecertificates/' . $releasecertificate->certificate)) {
                File::delete("storage/releasecertificates/" . $releasecertificate->certificate);
            }
            $releasedate =  date('Y-m-d', strtotime($request->release_date));
            $releasecertificate->holder_id = $student->id;
            $releasecertificate->certificate_name = $certificate->certificate_name;
            $releasecertificate->certificate = $filename;
            $releasecertificate->release_date = $releasedate;
            $releasecertificate->discription = $request->student_discription;
            $releasecertificate->name_color = $request->name_color;
            $releasecertificate->discription_color = $certificate->discription_color;
            $releasecertificate->discription_x_position = $request->discrip_x_position;
            $releasecertificate->discription_y_position = $request->discrip_y_position;
            $releasecertificate->name_x_position = $request->name_x_position;
            $releasecertificate->name_y_position = $request->name_y_position;
            $releasecertificate->name_font_size = $request->name_fontsize;
            $releasecertificate->discription_font_size = $request->discription_fontsize;
            $releasecertificate->discription_line_lenght = $request->line_length;
            $releasecertificate->save();
        }else{
            $releasecertificate = new ReleasedCertificate;
            $releasecertificate->holder_id = $student->id;
            $releasecertificate->certificate_name = $certificate->certificate_name;
            $releasecertificate->certificate = $filename;
            $releasecertificate->release_date = $request->release_date;
            $releasecertificate->discription = $request->student_discription;
            $releasecertificate->name_color = $request->name_color;
            $releasecertificate->discription_color = $certificate->discription_color;
            $releasecertificate->discription_x_position = $request->discrip_x_position;
            $releasecertificate->discription_y_position = $request->discrip_y_position;
            $releasecertificate->name_x_position = $request->name_x_position;
            $releasecertificate->name_y_position = $request->name_y_position;
            $releasecertificate->name_font_size = $request->name_fontsize;
            $releasecertificate->discription_font_size = $request->discription_fontsize;
            $releasecertificate->discription_line_lenght = $request->line_length;
            $releasecertificate->save();
        }
        $image->save(public_path('storage/releasecertificates/' . $filename));
        $image_url = asset('storage/releasecertificates/' . $filename);
        return response()->json([
            'image_url' => $image_url,
            'image_name'=>$filename,
        ]);
    }

    private function addText($image, $text, $x, $y, $fontFile, $fontSize, $fontColor)
    {
        $image->text($text, $x, $y, function ($font) use ($fontFile, $fontSize, $fontColor) {
            $font->file(public_path('storage/certificates/font/' . $fontFile));
            $font->size($fontSize);
            $font->color($fontColor);
        });
    }

    private function addLongText($image, $text, $x, $y, $fontFile, $fontSize, $fontColor, $maxWidth)
    {
        $lines = wordwrap($text, $maxWidth, "\n", true); // Wrap text into lines with maximum width
        $yPosition = $y; // Initial y position

        // Loop through each line and add it to the image
        foreach (explode("\n", $lines) as $line) {
            $image->text($line, $x, $yPosition, function ($font) use ($fontFile, $fontSize, $fontColor) {
                $font->file($fontFile);
                $font->size($fontSize);
                $font->color($fontColor);
            });

            $yPosition += $fontSize + 5; // Increase y position for the next line
        }
    }
}
