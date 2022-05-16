<div class="modal fade" id="modal-default">
	<form method="POST" action="entity/post_settings.php">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Configure Settings</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="type" id="m-type" value="">
					<input type="hidden" name="idd" id="m-idd" value="">
					<div class="row">
						<div class="col-md-12">
				            <div class="row pl-2 pr-2 pt-3">
				            	<div class="col-md-3" style="padding: 0.375rem 0.75rem;">
				            		<label class="form-control2">Alert Level</label>
				            	</div>
				            	<div class="col-md-9">
				            		<select id="cform-citymun" name="alert_level" class="form-control select2bs4 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
					                  <option selected disabled>-- Please Select Alert Level --</option>
					                  <option value="0">0</option>
					                  <option value="1">1</option>
					                  <option value="2">2</option>
					                  <option value="3">3</option>
					                  <option value="4">4</option>
					                  <option value="5">5</option>
					                </select>
				            	</div>
				            </div>
				          </div>
					</div>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save changes</button>
				</div>
			</div>
		</div>
	</form>
</div>