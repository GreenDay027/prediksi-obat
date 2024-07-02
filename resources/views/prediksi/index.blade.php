@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Prediksi Pemakaian Obat</h2>
    <form action="{{ route('prediksi.predict') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="obat_id">Pilih Obat:</label>
            <select name="obat_id" id="obat_id" class="form-control">
                @foreach($dataObat as $obat)
                    <option value="{{ $obat->id }}">{{ $obat->nama_obat }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="bulan">Jumlah Bulan untuk Prediksi:</label>
            <input type="number" name="bulan" id="bulan" class="form-control" min="1" required>
        </div>
        <button type="submit" class="btn btn-primary">Prediksi</button>
    </form>

    @if(isset($predictions))
        <div class="mt-4">
            <h3>Hasil Prediksi untuk {{ $obat->nama_obat }}</h3>
          <div class="card shadow border-0">
            <div class="card-body">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Bulan</th>
                    <th>Prediksi Pemakaian (Ft+m)</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($predictions as $prediction)
                    <tr>
                      <td>{{ $prediction['date'] }}</td>
                      <td>{{ $prediction['value'] }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>

          <form action="{{ route('save') }}" method="POST">
            @csrf
            <input type="hidden" name="nama_obat" value="{{ $obat->nama_obat }}">
            <input type="hidden" name="predictions" value="{{ json_encode($predictions) }}">
            <button type="submit" class="btn btn-primary mt-3">
                <i class="fas fa-save"></i> Simpan Perhitungan
            </button>
        </form>

            {{-- <h3>Nilai Perhitungan</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Periode</th>
                        <th>S1</th>
                        <th>S2</th>
                        <th>S3</th>
                        <th>a_t</th>
                        <th>b_t</th>
                        <th>c_t</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < count($St1s); $i++)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $St1s[$i] }}</td>
                            <td>{{ $St2s[$i] }}</td>
                            <td>{{ $St3s[$i] }}</td>
                            <td>{{ $ats[$i] ?? '0' }}</td>
                            <td>{{ $bts[$i] ?? '0' }}</td>
                            <td>{{ $cts[$i] ?? '0' }}</td>
                        </tr>
                    @endfor
                </tbody>
            </table> --}}
        </div>
    @endif
</div>
@endsection
