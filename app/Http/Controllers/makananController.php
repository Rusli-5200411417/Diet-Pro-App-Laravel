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
        return view('makanan', compact('makanans'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        // Pemeriksaan apakah $keyword tidak bernilai null dan memiliki panjang minimal 3 karakter
        if ($keyword !== null && strlen($keyword) >= 3) {
            $makanans = Makanan::where(function ($query) use ($keyword) {
                $query->where('Nama_Bahan', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('Jenis', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('Nama_Bahan', 'REGEXP', '.*' . $keyword[0] . '.*' . $keyword[1] . '.*' . $keyword[2] . '.*')
                    ->orWhere('Jenis', 'REGEXP', '.*' . $keyword[0] . '.*' . $keyword[1] . '.*' . $keyword[2] . '.*');
            })->paginate(10);
        } else {
            // Jika $keyword kurang dari 3 karakter atau null, tidak perlu melakukan pencarian
            $makanans = [];
        }

        return view('table', compact('makanans'));
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

                // Get the header row to map column names
                $headers = array_shift($data);
                // Trim whitespace from column names
                $headers = array_map('trim', $headers);

                // Validate the header columns here if needed
                // For example, you can check if required columns are present, etc.

                $importedData = [];
                foreach ($data as $row) {
                    // Process each row and split the data containing double quotes
                    $rowData = [];
                    foreach ($row as $index => $value) {
                        $values = str_getcsv($value);
                        // Remove unnecessary double quotes from each value
                        $values = array_map(function ($val) {
                            return trim($val, '"');
                        }, $values);
                        $rowData = array_merge($rowData, $values);
                    }

                    // Check if the number of values in the row matches the number of headers
                    if (count($rowData) === count($headers)) {
                        $rowData = array_combine($headers, $rowData);
                        $importedData[] = $rowData;
                    } else {
                        Log::warning('Invalid row data: ' . json_encode($rowData));
                    }
                }

                foreach ($importedData as $rowData) {
                    // Insert the data into the database
                    Log::info('Data to be saved to the database: ' . json_encode($rowData));
                    Makanan::create($rowData);
                }

                return redirect()->back()->with('success', 'Data CSV berhasil diimpor.');
            }

            return redirect()->back()->with('error', 'Gagal memproses file CSV. Pastikan file yang diunggah benar.');
        } catch (\Exception $e) {
            // Catat kesalahan
            Log::error('Kesalahan mengimpor data CSV: ' . $e->getMessage());

            // Opsional, Anda bisa mengarahkan kembali dengan pesan kesalahan
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
  
}
