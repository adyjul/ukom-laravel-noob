<div class="col-md-12">
    <div class="block block-rounded  content-title-left {{ $status }}">
        <div class="block-header">
            <h3 class="block-title">Cek List Proposal</h3>
            <div class="block-options">
                <button type="button" class="btn-block-option" data-toggle="block-option"
                    data-action="fullscreen_toggle"><i class="si si-size-fullscreen"></i></button>
                </button>
                <button type="button" class="btn-block-option" data-toggle="block-option"
                    data-action="content_toggle"><i class="si si-arrow-up"></i></button>
            </div>
        </div>
        <div class="block-content">
           
           
            
            <div class="row">
                <div class="col-md-6 col-xs-6">
                    <div class="custom-control custom-switch custom-control-primary my-1">
                        <input type="checkbox" class="custom-control-input checklist" id="cek_proposal"
                            name="checklist" {{ $data['obj']->proposal_files != null ? 'checked' : '' }} disabled>
                        <label class="custom-control-label"
                            for="cek_proposal">Proposal</label>
                    </div>
                </div>
                <div class="col-md-6 col-xs-6">
                    <div class="custom-control custom-switch custom-control-primary my-1">
                        <input type="checkbox" class="custom-control-input checklist" id="cek_rab"
                            name="checklist" {{ $data['obj']->anggaran != null ? 'checked' : '' }} disabled>
                        <label class="custom-control-label"
                            for="cek_rab">RAB</label>
                    </div>
                </div>
                <div class="col-md-6 col-xs-6">
                    <div class="custom-control custom-switch custom-control-primary my-1">
                        <input type="checkbox" class="custom-control-input checklist" id="cek_kurikulum"
                            name="checklist" {{ $data['obj']->rps != null ? 'checked' : '' }}  disabled>
                        <label class="custom-control-label"
                            for="cek_kurikulum">Capaian Luaran</label>
                    </div>
                </div>
                <div class="col-md-6 col-xs-6">
                    <div class="custom-control custom-switch custom-control-primary my-1">
                        <input type="checkbox" class="custom-control-input checklist" id="cek_dosen_pt"
                            name="checklist"  {{ count($data['pengajar_pt']) > 0 ? 'checked' : '' }} disabled>
                        <label class="custom-control-label"
                            for="cek_dosen_pt">Data Dosen PT</label>
                    </div>
                </div>
                <div class="col-md-6 col-xs-6">
                    <div class="custom-control custom-switch custom-control-primary my-1">
                        <input type="checkbox" class="custom-control-input checklist" id="cek_dosen_dudi"
                            name="checklist" {{ count($data['pengajar_dudi']) > 0 ? 'checked' : '' }} disabled>
                        <label class="custom-control-label"
                            for="cek_dosen_dudi">Data Pengajar DUDI</label>
                    </div>
                </div>
                @php
                    $cek = false;
                    
                   

                    if($data['dudi'] == null){
                        $cek = false;
                    }

                    if($data['dudi'] != null){
                        foreach ($data['dudi'] as $item) {
                            if($item['mou'] != null){
                                $cek = true;
                            }
                        }
                    }
                   
                    
                    
                @endphp
                <div class="col-md-6 col-xs-6">
                    <div class="custom-control custom-switch custom-control-primary my-1">
                        <input type="checkbox" class="custom-control-input checklist" id="cek_mou"
                            name="checklist" {{ $cek ? 'checked' : '' }} disabled>
                        <label class="custom-control-label"
                            for="cek_mou">MOU DUDI</label>
                    </div>
                </div>
                               
            </div>
        </div>
    </div>
</div>
