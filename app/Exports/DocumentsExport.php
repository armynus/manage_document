<?php

namespace App\Exports;

use App\Models\Documents;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromView;

class DocumentsExport implements FromCollection,WithHeadings,WithMapping
{
    
    public function __construct(int $year, int $category_id) {
    	$this->year = $year;
        $this->category_id = $category_id;
    }

    public function collection()
    {
        if ($this->category_id == 1) {
            return Documents::whereYear('document_time', $this->year)
            ->where('category_id', $this->category_id)
            ->orderBy('stt', 'asc')
            ->get();
        }else{
            return Documents::whereYear('document_time', $this->year)
            ->where('category_id', $this->category_id)
            ->orderBy('document_number', 'asc')
            ->get();
        }
    }

    //Thêm hàng tiêu đề cho bảng
    public function headings() :array {
        if($this->category_id == 1){
            return ["Ngày tháng đến", "Số đến", "Tên cơ quan gửi đến", "Số & ký hiệu văn bản", "Ngày, tháng văn bản", "Tên loại và trích yếu nội dung", "Đơn vị hoặc người nhận"];  
        }else{
            return ["Ngày tháng", "Số Văn bản", "Người ký văn bản", "Ngày, tháng QĐ", "Tên loại và trích yếu nội dung văn bản", "Đơn vị hoặc người nhận"];  

        }
    	
    }
    //Thêm dữ liệu cho bảng
    public function map($documents): array {
        if($this->category_id == 1){
            return [
                $documents->created_at= date('d-m-Y', strtotime($documents->created_at)),
                $documents->stt,
                $documents->department_send,
                $documents->document_number,
                $documents->document_time = date('d-m-Y', strtotime($documents->document_time)),
                $documents->document_content,
                $documents->receiver,

            ];
        }else{
            return [
                $documents->created_at= date('d-m-Y', strtotime($documents->created_at)),
                $documents->document_number,
                $documents->signer,
                $documents->document_time = date('d-m-Y', strtotime($documents->document_time)),
                $documents->document_content,
                $documents->receiver,
            ];
        }
        
    }
}
