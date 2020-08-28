<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $maxFileSize = $this->getMaxUploadFileSize();

        return [
            'file' => "required|max:$maxFileSize|mimes:xlsx,xls,csv",
        ];
    }

    /**
     * @return int
     */
    private function getMaxUploadFileSize(): int
    {
        $maxFileSize = ini_get('upload_max_filesize');
        $measure = strtolower($maxFileSize[strlen($maxFileSize)-1]);
        $maxFileSize = (int)($maxFileSize);
        switch($measure) {
            case 'g':
                $maxFileSize *= (1024 * 1024 * 1024);
                break;
            case 'm':
                $maxFileSize *= (1024 * 1024);
                break;
            case 'k':
                $maxFileSize *= 1024;
                break;
        }

        return $maxFileSize;
    }
}
