 <form action="<?php echo e(route('vehicle.update', $vehicle->id)); ?>" method="POST" class="needs-validation modal-content"
     enctype="multipart/form-data">
     <?php echo csrf_field(); ?>
     <?php echo method_field('PUT'); ?>
     <div class="card-header my-3 p-2 border-bottom">
         <h4>Edit Vehicle</h4>
     </div>
     <div class="modal-body">
         <div class="row">
             <div class="col-md-12 col-lg-6">
                 <div class="form-group row my-2">
                     <label for="model" class="col-sm-5 col-form-label">Vehicle Model <i
                             class="text-danger">*</i></label>
                     <div class="col-sm-7">
                         <input name="model" class="form-control" type="text" placeholder="Vehicle Model"
                             id="model" value="<?php echo e(old('model', $vehicle->model)); ?>" required>
                     </div>
                 </div>

                 <div class="form-group row my-2">
                     <label for="make" class="col-sm-5 col-form-label">Vehicle Make <i
                             class="text-danger">*</i></label>
                     <div class="col-sm-7">
                         <input name="make" autocomplete="off" required class="form-control" type="text"
                             placeholder="Vehicle Make" id="make" value="<?php echo e(old('make', $vehicle->make)); ?>">
                     </div>
                 </div>

                 <div class="form-group row my-2">
                     <label for="year" class="col-sm-5 col-form-label">Vehicle Year of Manufacturer <i
                             class="text-danger">*</i></label>
                     <div class="col-sm-7">
                         <input name="year" class="form-control" type="number" placeholder="Year of Manufacturer"
                             id="year" value="<?php echo e(old('year', $vehicle->year)); ?>" required>
                     </div>
                 </div>
                 <div class="form-group row my-2">
                     <label for="plate_number" class="col-sm-5 col-form-label">Vehicle Number Plate <i
                             class="text-danger">*</i></label>
                     <div class="col-sm-7">
                         <input name="plate_number" class="form-control" type="text" placeholder="Enter Number Plate"
                             id="plate_number" value="<?php echo e(old('plate_number', $vehicle->plate_number)); ?>" required>
                     </div>
                 </div>
                 <div class="form-group row my-2">
                     <label for="fuel_type" class="col-sm-5 col-form-label">Fuel Type <i
                             class="text-danger">*</i></label>
                     <div class="col-sm-7">
                         <input name="fuel_type" class="form-control" type="text"
                             placeholder="Enter Vehicle Fuel Type" id="fuel_type"
                             value="<?php echo e(old('fuel_type', $vehicle->fuel_type)); ?>" required>
                     </div>
                 </div>
                 <div class="form-group row my-2">
                     <label for="engine_size" class="col-sm-5 col-form-label">Engine Size <i
                             class="text-danger">*</i></label>
                     <div class="col-sm-7">
                         <input name="engine_size" class="form-control" type="number" placeholder="Enter Engine Size"
                             id="engine_size" value="<?php echo e(old('engine_size', $vehicle->engine_size)); ?>" required>
                     </div>
                 </div>
                 <div class="form-group row my-2">
                     <label for="organisation_id" class="col-sm-5 col-form-label">Select Vehicle Organisation</label>
                     <div class="col-sm-7">
                         <select class="form-control basic-single select2" name="organisation_id" id="organisation_id">
                             <option value="">None</option>
                             <?php $__currentLoopData = $organisations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $organisation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <option value="<?php echo e($organisation->id); ?>"
                                     <?php echo e(old('organisation_id', $vehicle->organisation_id) == $organisation->id ? 'selected' : ''); ?>>
                                     <?php echo e($organisation->user->name); ?>

                                 </option>
                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                         </select>
                     </div>
                 </div>
                 <div class="form-group row my-2">
                     <label for="driver_id" class="col-sm-5 col-form-label">Assigned Driver</label>
                     <div class="col-sm-7">
                         <select class="form-control" name="driver_id" id="driver_id">
                             <option value="">None</option>
                             <?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <option value="<?php echo e($driver->id); ?>"
                                     <?php echo e(old('driver_id', $vehicle->driver_id) == $driver->id ? 'selected' : ''); ?>>
                                     <?php echo e($driver->user->name); ?>

                                 </option>
                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                         </select>
                     </div>
                 </div>

                 <div class="form-group row my-2">
                     <label for="vehicle_class" class="col-sm-5 col-form-label">Vehicle Class</label>
                     <div class="col-sm-7">
                         <select class="form-control" name="vehicle_class" id="vehicle_class">
                             <option value="">None</option>
                             <?php $__currentLoopData = $vehicleClasses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <option value="<?php echo e($class->name); ?>"
                                     <?php echo e(old('vehicle_class', $vehicle->class) == $class->name ? 'selected' : ''); ?>>
                                     Class <?php echo e($class->name); ?>

                                 </option>
                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                         </select>
                     </div>
                 </div>
             </div>

             <div class="col-md-12 col-lg-6">
                 <div class="form-group row my-2">
                     <label for="color" class="col-sm-5 col-form-label">Vehicle Color <i
                             class="text-danger">*</i></label>
                     <div class="col-sm-7">
                         <input name="color" class="form-control" type="text" placeholder="Enter Vehicle Color"
                             id="color" value="<?php echo e(old('color', $vehicle->color)); ?>" required>
                     </div>
                 </div>
                 <div class="form-group row my-2">
                     <label for="seats" class="col-sm-5 col-form-label">No of Seats <i
                             class="text-danger">*</i></label>
                     <div class="col-sm-7">
                         <input name="seats" class="form-control" type="number" placeholder="No of Seats"
                             id="seats" value="<?php echo e(old('seats', $vehicle->seats)); ?>" required>
                     </div>
                 </div>
                 <div class="form-group row my-2">
                     <label for="vehicle_avatar" class="col-sm-5 col-form-label">Vehicle Avatar</label>
                     <div class="col-sm-7">
                         <input name="vehicle_avatar" class="form-control" type="file" id="vehicle_avatar">
                         <?php if($vehicle->avatar): ?>
                             <img src="<?php echo e(asset('images/' . $vehicle->avatar)); ?>" alt="Vehicle Avatar"
                                 class="img-thumbnail mt-2" style="max-height: 150px;">
                         <?php endif; ?>
                     </div>
                 </div>
             </div>
         </div>
         <div class="modal-footer">
             <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
             <button class="btn btn-success" type="submit">Update</button>
         </div>
 </form>
<?php /**PATH /home/kknuicdz/metroBerry/resources/views/vehicle/edit.blade.php ENDPATH**/ ?>