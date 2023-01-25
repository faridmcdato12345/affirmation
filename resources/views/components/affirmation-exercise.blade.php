
<form x-data='exerciseForm'>
    <div id="sheet-wizard-step-1" class="menu menu-box-bottom menu-box-detached rounded-m">
        <div class="content">
            <span class="font-600 color-highlight d-block mb-n2">Step 1 / 3</span>
            <h1>Alignment</h1>
            <h5>Do you believe this affirmation?</h5>
            <p>Really take some time to reflect on today's affirmation.</p>
            <label for="form5" class="color-highlight disabled">Select A Value</label>
            <div class="row mx-0">
                <div class="col-6">
                    <a href="#" data-menu="sheet-wizard-step-2-affirmative" class="btn btn-xl btn-full shadow-s bg-green-dark rounded-sm font-900" x-on:click="formData.believe = true">I believe</a>
                </div>
                <div class="col-6">
                    <a href="#" data-menu="sheet-wizard-step-2-negative" class="btn btn-xl btn-full shadow-s bg-red-dark rounded-sm font-900" x-on:click="formData.believe = false">I do not believe</a>
                </div>
            </div>
            <em></em>
        </div>
    </div>

    <div id="sheet-wizard-step-2-negative" class="menu menu-box-bottom menu-box-detached rounded-m">
        <div class="content">
            <span class="font-600 color-highlight d-block mb-n2">Step 2 / 3</span>
            <h1>Challenge Negative Beliefs</h1>
            <p>
                Not all beliefs we have are true and we can shift them closer to reality by finding examples that challenge those beliefs.
            </p>
            <h5>Try to Think of Three Times Your Actions Have Challenged This Belief.</h5>
            <div class="input-style no-borders no-icon">
                <input name="input1" x-model="formData.input1" type="text" placeholder="Your First Experience">
                <input name="input2" x-model="formData.input2" type="text" placeholder="Your Second Experience">
                <input name="input3" x-model="formData.input3" type="text" placeholder="Your Third Experience">
                <em></em>
            </div>
            <a href="#" data-menu="sheet-wizard-step-3" class="btn btn-full btn-m rounded-m bg-blue-dark font-700 text-uppercase mt-4 mb-4">Next Step</a>
        </div>
    </div>

    <div id="sheet-wizard-step-2-affirmative" class="menu menu-box-bottom menu-box-detached rounded-m">
        <div class="content">
            <span class="font-600 color-highlight d-block mb-n2">Step 2 / 3</span>
            <h1>Own This Affirmation</h1>
            <p>
                You are the source of the change you want to see in your life.
            </p>
            <h5>Try to Think of Three Times Your Actions Have Been in Line With This Belief.</h5>
            <div class="input-style no-borders no-icon">
                <input name="input1" type="text" x-model="formData.input1" placeholder="Your First Experience">
                <input name="input2" type="text" x-model="formData.input2" placeholder="Your Second Experience">
                <input name="input3" type="text" x-model="formData.input3" placeholder="Your Third Experience">
                <em></em>
            </div>
            <a href="#" data-menu="sheet-wizard-step-3" class="btn btn-full btn-m rounded-m bg-blue-dark font-700 text-uppercase mt-4 mb-4">Next Step</a>
        </div>
    </div>

    <div id="sheet-wizard-step-3"  class="menu menu-box-bottom menu-box-detached rounded-m">
        <div class="content text-center px-3">
            <i class="fa fa-heart scale-box color-red-dark fa-5x pb-3 pt-2"></i>
            <h1>Thank you!</h1>
            <p class="px-2 mb-3">
                Take a moment to thank yourself for taking care of you.
            </p>
            {{-- <button type="submit" class="close-menu btn btn-full btn-m rounded-m bg-red-dark font-700 text-uppercase mb-4">Stay Awesome!</button> --}}
            <a href="#" class="close-menu btn btn-full btn-m rounded-m bg-red-dark font-700 text-uppercase mb-4" x-on:click='submitExercise'>Stay Awesome!</a>
        </div>
    </div>
</form>

<div id="toast-3" class="toast toast-tiny toast-top bg-green-dark" data-bs-delay="3000" data-autohide="true"><i class="fa fa-check me-3"></i>Success!</div>
<div id="toast-4" class="toast toast-tiny toast-top bg-red-dark" data-bs-delay="3000" data-autohide="true"><i class="fa fa-times me-3"></i>Error!</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('exerciseForm', () =>({
            url: "{{ route('exercise.store') }}",
            formData: {
                user_id: {{Auth::user()->id}},
                progress_id: {{ $progress_id }},
                believe: "",
                input1: "",
                input2: "",
                input3: "",
            },
            toast: "",
            submitExercise() {
                fetch(this.url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(this.formData)
                })
                    .then(() => {
                        this.formData.believe = "",
                        this.formData.input1 = "",
                        this.formData.input2 = "",
                        this.formData.input3 = "",
                        this.toast = document.getElementById('toast-3')
                    })
                    .catch(() => {
                        this.toast = document.getElementById('toast-4')
                    })
                    .finally(() => {
                        toastID = new bootstrap.Toast(this.toast);
                        toastID.show();
                    });
            }
        }))
    })
</script>
