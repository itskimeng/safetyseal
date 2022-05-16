<div class="row">
  <div class="col-md-12">
    <div class="menu">
      
      <?php foreach ($pps as $key => $pp): ?>
        <div class="accordion dropbox">
            <div class="accordion-group">
                <div class="accordion-heading area <?= $colors[$key]; ?>">
                    <div style="float: right;margin-right: 3px;margin-top: 8px;">
                      <?php if ($pp['alert_level'] > 0): ?>
                        <b>Alert Level <?= $pp['alert_level']; ?></b> &nbsp;
                      <?php endif ?>
                      <a href="#" class="modal-settings" data-toggle="modal" data-target="#modal-default" style="color: gray;" data-type="province" data-province="<?= $key; ?>" data-title="<?= $pp['province']; ?>"><i class="fa fa-edit"></i></a>
                    </div>
                    <a class="accordion-toggle" data-toggle="collapse" href="#area<?= $key; ?>" style="color:inherit;"><b><i class="fa fa-angle-right" aria-hidden="true"></i> <?= strtoupper($pp['province']); ?></b></a>
                </div>
                
                <?php $counter = 0; ?>
                  <div class="accordion-body collapse" id="area<?= $key; ?>">
                      <div class="accordion-inner">
                        <?php foreach ($pp['clusters'] as $index => $cluster): ?>
                          <?php $counter += 1; ?>
                          <div class="accordion" id="equipamento<?= $index; ?>">
      
                              <div class="accordion-group">
                                  <div class="accordion-heading equipamento">
                                      <div style="float: right;margin-right: 3px;margin-top: 8px;">
                                        <?php if (isset($cluster[$index]['ch_alert_level']) AND $cluster[$index]['ch_alert_level'] > 0): ?>
                                          <b>Alert Level <?= $cluster[$index]['ch_alert_level']; ?></b> &nbsp;
                                        <?php endif ?>
                                        <a href="#" class="modal-settings" data-toggle="modal" data-target="#modal-default" style="color: gray;" data-type="cluster" data-cluster="<?= $index; ?>" data-title="Cluster <?= $counter; ?>"><i class="fa fa-edit"></i></a>
                                      </div>
                                      <a class="accordion-toggle" data-toggle="collapse" href="#ponto<?= $index; ?>" style="color:inherit;">Cluster <?= $counter; ?></a>
                                  </div>
      
                                  <div class="accordion-body collapse" id="ponto<?= $index; ?>">
                                    <div class="accordion-inner" id="servico">
                                        <ul class="list-group">
                                          <?php foreach ($cluster as $idd => $cl): ?>
                                            <li class="list-group-item" style="padding: 0.5rem 1rem;">
                                              <div style="float: right;margin-right: 3px;">
                                                <?php if (isset($cl['cm_alert_level']) AND $cl['cm_alert_level'] > 0): ?>
                                                  <b>Alert Level <?= $cl['cm_alert_level']; ?></b> &nbsp;
                                                <?php endif ?>
                                                <a href="#" class="modal-settings" data-toggle="modal" data-target="#modal-default" style="color: gray;" data-type="lgu" data-lgu="<?= $cl['lgu_id']; ?>" data-title="<?= $cl['lgu']; ?>"><i class="fa fa-edit"></i></a>
                                              </div>
                                              <a href="#" style="color:inherit;"> <?= $cl['lgu']; ?></a>
                                            </li>
                                          <?php endforeach ?>
                                        </ul>
                                    </div>
                                  </div>
                              </div>
                          </div>
                        <?php endforeach ?>  
                      </div>
                  </div>

            </div>
        </div><!-- /accordion -->
        
      <?php endforeach ?>         
       
    </div>
  </div>
</div>