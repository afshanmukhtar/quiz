<section class="quiz-forms">
	<div class="row justify-content-center">
		<div class="col-12 col-sm-9 col-md-6 col-lg-4 mx-auto animated fadeInDown visible" data-animation="fadeInDown" data-animation-delay="100">
			<div id="quiz-status" data-percent="80" class="skillbar-status">
				<p class="skillbar-bar"></p>
				<span class="skill-bar-percent"></span>
			</div>
		</div>
	</div>
	<p class="animated fadeInUp visible" data-animation="fadeInUp" data-animation-delay="300">Strategic Connections Profile (SCP<sup>&#174;</sup>) is a 28 item survey that looks at seven kinds of strategic relationship -the ones you need and the ones you don't need. Each question has a minimum score of 1 point and a maximum score of 5 point based on the scale below. Select the word that is currently true of you. Be realistic in your assessment and do not spend an excessive amount of time deliberating over the responses. There are no right or wrong answers. It is start of a journey toward strong and viable strategic connections.</p>

	<h3 class="title-inner animated fadeInDown visible" data-animation="fadeInDown" data-animation-delay="500">As a person/leader/professional...</h3>

    <form action="" method="post" id="quiz-3" class="quiz-form">
		<div class="row justify-content-center">
			<div class="col-12"></div>
			<div class="col-12">
			<?php 
            if(!$quiz_list){
                echo 'No Question!';
            }
            else{
                foreach($quiz_list as $quiz){
                    $cat_name = $quiz->category; 
                    $group = $quiz->quiz_group;
            ?>
                    <div class="form-group quiz-questions">
    					<p class="quiz-qiestion animated fadeInLeft visible" id="num-<?php echo $quiz->id; ?>" data-animation="fadeInLeft" data-animation-delay="500"><?php echo $quiz->question; ?></p>
    					<div class="question-box animated fadeInRight visible" data-animation="fadeInRight" data-animation-delay="500">
    						<input type="radio" name="cat[<?php echo $group; ?>][<?php echo $cat_name; ?>][<?php echo $quiz->id; ?>]" value="1" id="never-<?php echo $quiz->id; ?>"><label for="never-<?php echo $quiz->id; ?>">Never</label>
    						<input type="radio" name="cat[<?php echo $group; ?>][<?php echo $cat_name; ?>][<?php echo $quiz->id; ?>]" value="2" id="rarely-<?php echo $quiz->id; ?>"><label for="rarely-<?php echo $quiz->id; ?>">Rarely</label>
    						<input type="radio" name="cat[<?php echo $group; ?>][<?php echo $cat_name; ?>][<?php echo $quiz->id; ?>]" value="3" id="sometimes-<?php echo $quiz->id; ?>"><label for="sometimes-<?php echo $quiz->id; ?>">Sometimes</label>
    						<input type="radio" name="cat[<?php echo $group; ?>][<?php echo $cat_name; ?>][<?php echo $quiz->id; ?>]" value="4" id="farequently-<?php echo $quiz->id; ?>"><label for="farequently-<?php echo $quiz->id; ?>">Frequently</label>
    						<input type="radio" name="cat[<?php echo $group; ?>][<?php echo $cat_name; ?>][<?php echo $quiz->id; ?>]" value="5" id="always-<?php echo $quiz->id; ?>"><label for="always-<?php echo $quiz->id; ?>">Always</label>
    					</div>
                    </div>
            <?php
                }
            ?>
            <?php 
            }
            ?>
            </div>
        </div>
		<div class="row justify-content-center">
			<div class="col-md-12">
                <div class="text-center margin-top">
                    <button data-animation="flipInY" data-animation-delay="800" class="btn btn-quiz submit-button animated flipInY visible" id="quiz_next"  data-step="finish" type="submit">Next &#8594;</button>
                </div>
            </div>
        </div>
	</form>
</section>