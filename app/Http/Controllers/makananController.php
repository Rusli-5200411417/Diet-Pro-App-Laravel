<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Makanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;

class makananController extends Controller
{
    public function index()
    {
        $makanans = Makanan::orderBy('Nama_Bahan', 'asc')->paginate(10);
        $keyword = '';
        return view('makanan', compact('makanans', 'keyword'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
    
        if ($keyword !== null && strlen($keyword) >= 3) {
            $makanans = Makanan::where(function ($query) use ($keyword) {
                $query->where('Nama_Bahan', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('Jenis', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('Nama_Bahan', 'REGEXP', '.*' . $keyword[0] . '.*' . $keyword[1] . '.*' . $keyword[2] . '.*')
                    ->orWhere('Jenis', 'REGEXP', '.*' . $keyword[0] . '.*' . $keyword[1] . '.*' . $keyword[2] . '.*');
            })->paginate(10);
    
            $makanans->appends(['keyword' => $keyword]); // Append the keyword to pagination links
        } else {
            $makanans = [];
        }
    
        return view('makanan', compact('makanans', 'keyword'));
    }

    public function importData(Request $request)
    {
        try {
            $request->validate([
                'csv_file' => 'required|mimes:csv,txt'
            ]);

            if ($request->hasFile('csv_file')) {
                $path = $request->file('csv_file')->getRealPath();
                $data = array_map('str_getcsv', file($path));

                $headers = array_shift($data);
                $headers = array_map('trim', $headers);

                $importedData = [];
                foreach ($data as $row) {
                    $rowData = [];
                    foreach ($row as $index => $value) {
                        $values = str_getcsv($value);
                        $values = array_map(function ($val) {
                            return trim($val, '"');
                        }, $values);
                        $rowData = array_merge($rowData, $values);
                    }

                    if (count($rowData) === count($headers)) {
                        $rowData = array_combine($headers, $rowData);
                        $importedData[] = $rowData;
                    } else {
                        Log::warning('Invalid row data: ' . json_encode($rowData));
                        return redirect()->back()->with('error', 'Data CSV gagal diimpor.');
                    }
                }

                // Check if there are records with null nama_bahan before importing
                $nullNamaBahanCount = Makanan::whereNull('Nama_Bahan')->count();
                if ($nullNamaBahanCount > 0) {
                    // Delete records with null nama_bahan
                    Makanan::whereNull('Nama_Bahan')->delete();
                    Log::info('Deleted records with null nama_bahan');  
                }

                foreach ($importedData as $rowData) {
                    if (!empty($rowData['Nama_Bahan'])) {
                        Makanan::create($rowData);
                    }
                }

                return redirect()->back()->with('success', 'Data CSV berhasil diimpor.');
            }

            return redirect()->back()->with('error', 'Gagal memproses file CSV. Pastikan file yang diunggah benar.');
        } catch (\Exception $e) {
            Log::error('Kesalahan mengimpor data CSV: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengimpor data CSV. Periksa format file dan coba lagi.');
        }
    }

    public function tambah(Request $request){
        $validatedData = $request->validate([
            'Nama_Bahan' => 'required',
            'Jenis' => 'required',
        ]);

        Makanan::create($validatedData);

        return redirect()->route('makanan');
    }

    public function edit(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'Nama_Bahan' => 'required',
            'Jenis' => 'required',
        ]);

        if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $data['Nama_Bahan'] = $request->Nama_Bahan;
        $data['Ukuran_Porsi'] = $request->Ukuran_Porsi;
        $data['Takaran'] = $request->Takaran;
        $data['Energi_kkal'] = $request->Energi_kkal;
        $data['Protein_g'] = $request->Protein_g;
        $data['Lemak_g'] = $request->Lemak_g;
        $data['KH_g'] = $request->KH_g;
        $data['Serat_Total_g'] = $request->Serat_Total_g;
        $data['Natrium_mg'] = $request->Natrium_mg;
        $data['Kalium_mg'] = $request->Kalium_mg;
        $data['Gula_Total_g'] = $request->Gula_Total_g;
        $data['Jenis'] = $request->Jenis;

        Makanan::whereId($id)->update($data);
   
    // dd($data);

    return redirect()->route('makanan');
    }

    public function hapus(Request $request,$id){
        $makanan = Makanan::find($id);

        if($makanan){
            $makanan->delete();
        }
        return redirect()->route('makanan');
    }
  
    public function hapusSemua(){
        Makanan::truncate();

        return redirect()->route('makanan')->with('success', 'Semua data berhasil dihapus');
    }
}
