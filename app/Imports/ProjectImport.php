<?php

namespace App\Imports;

use App\Models\Projects;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProjectImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Projects([
            'nama'           => $row['nama'],
            'deskripsi'      => $row['deskripsi'],
            'kecamatan_id'   => $row['kecamatan_id'],
            'kelurahan'      => $row['kelurahan'],
            'pengawas_id'    => $row['pengawas_id'],
            'anggaran'       => $row['anggaran'],
            'tender'         => $row['tender'],
            't_awal'         => $row['t_awal'],
            't_akhir'        => $row['t_akhir'],
            'status'         => $row['status'],
            'latitude'       => $row['latitude'],
            'longitude'      => $row['longitude'],
            'jenis'          => $row['jenis'],
            'created_at'     => date('Y-m-d H:i:s'),
            'updated_at'     => date('Y-m-d H:i:s'),
        ]);
    }
}
