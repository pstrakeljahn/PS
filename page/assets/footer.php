<?php

echo 
'</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css" />

    <script>
        $(document).ready(function() {
            var date_input = $(\'input[name="date"]\');
            console.log(date_input);
            date_input.datepicker({
                format: \'dd.mm.yyyy\',
                container: "body",
                todayHighlight: true,
                autoclose: true,
            })
        })
    </script>
</body>

</html>';