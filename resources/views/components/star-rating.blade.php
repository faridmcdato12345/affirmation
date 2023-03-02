<div class="d-flex align-items-center justify-content-center">   
    <!-- star rating -->
    <div class="rating-wrapper">
        <!-- star 5 -->
        <input type="radio" id="{{$inputName}}-5-star-rating" name="{{$inputName}}" x-model="formData.{{$inputName}}" value="5">
        <label for="{{$inputName}}-5-star-rating" class="star-rating">
            <i class="fas fa-star d-inline-block"></i>
        </label>
        
            <!-- star 4 -->
        <input type="radio" id="{{$inputName}}-4-star-rating" name="{{$inputName}}" x-model="formData.{{$inputName}}" value="4">
        <label for="{{$inputName}}-4-star-rating" class="star-rating star">
            <i class="fas fa-star d-inline-block"></i>
        </label>
        
            <!-- star 3 -->
        <input type="radio" id="{{$inputName}}-3-star-rating" name="{{$inputName}}" x-model="formData.{{$inputName}}" value="3">
        <label for="{{$inputName}}-3-star-rating" class="star-rating star">
            <i class="fas fa-star d-inline-block"></i>
        </label>
        
        <!-- star 2 -->
        <input type="radio" id="{{$inputName}}-2-star-rating" name="{{$inputName}}" x-model="formData.{{$inputName}}" value="2">
        <label for="{{$inputName}}-2-star-rating" class="star-rating star">
            <i class="fas fa-star d-inline-block"></i>
        </label>
        
        <!-- star 1 -->
        <input type="radio" id="{{$inputName}}-1-star-rating" name="{{$inputName}}" x-model="formData.{{$inputName}}" value="1">
        <label for="{{$inputName}}-1-star-rating" class="star-rating star">
            <i class="fas fa-star d-inline-block"></i>
        </label>
    </div>
</div>