<html>
    <head>
    <style>
    body {font-family: Cambria, sans-serif;
    	font-size: 10pt;
        background: #fff;
    }
    p {	margin: 0pt; }
    p, h2,h3,h4{
        width: 100%;
    }
    h3{
        font-size: 12pt;
    }
    h2{
        font-size: 16pt;
        }
    table {
    	border: none;
    }
    td { vertical-align: top; }
    
     
    .col-40{
        width: 40%;
    }
    .col-50{
        width: 50%;
    }
    
    .col-60{
        width: 60%;
    }
    .float-left{
        float: left;
    }
    .float-right{
        float: right;
    }
    .clear{
        clear: both;
    }
    .grey-bg{
        /* Permalink - use to edit and share this gradient: https://colorzilla.com/gradient-editor/#192d43+0,2b4b72+25,365f91+50,2b4b72+75,192d43+100 */
        background: #192d43; /* Old browsers */
        background: -moz-linear-gradient(top,  #192d43 0%, #2b4b72 25%, #365f91 50%, #2b4b72 75%, #192d43 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(top,  #192d43 0%,#2b4b72 25%,#365f91 50%,#2b4b72 75%,#192d43 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom,  #192d43 0%,#2b4b72 25%,#365f91 50%,#2b4b72 75%,#192d43 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#192d43', endColorstr='#192d43',GradientType=0 ); /* IE6-9 */

    }
    .cat-name{
        width:70%;
        float:left;
    }
    .score{
        width:30%;
        float:left;
        text-align:right;
    }
    .line-blue{
        width:60%;
        margin: 0 auto;
        height:1mm;
        background: #002163
    }
    .text-blue{
        color:#0000cc;
    }
    .text-carmine{
        color: #943634;
    }
    .bg-green{
        /* background: #c2d69b;*/
        background: #f1f1f1;
    }
    
    </style>
    </head>
    <body>
    <?php 
    $Aspirant_score = (int)$score_separate['Aspirant'];
    $Subordinate_score = (int)$score_separate['Subordinate'];
    $Personal_score = (int)$score_separate['Personal'];
    $Mentor = (int)$score_separate['Mentor'];
    $Professional = (int)$score_separate['Professional'];
    $Global = (int)$score_separate['Global'];
    $Accountability = (int)$score_separate['Accountability'];
    $Toxic = (int)$score_separate['Toxic'];
    $mname = (!empty($uname)) ? strtoupper($uname) : 'CARMELA NANTON' ;
    ?>
        <div>
            <div class="col-60 float-left" style="background: #defcfe;" >
                <div style="vertical-align: middle;height: 40px;line-height: 45px;padding: 0 4mm;">
                    <span><?php echo date('d/m/Y'); ?> | Carmel Connections Inc. | <?php echo (!empty(get_option('tdq_phone'))) ? get_option('tdq_phone') : '833-544-LEAD' ; ?></span>
                </div>
            </div>
            <div class="col-40 float-left" style="background: #f1f1f1;text-align: right;" >
                <div style="height: 43px;padding: 0 2mm;">
                    <strong>Prepared Exclusively for</strong><br />
                    <h3 style="margin: 0;"><?php echo strlen($mname) > 14 ? substr($mname,0,14).'.' : $mname; ?></h3>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="grey-bg">
            <div class="float-left col-60">
                <div style="padding: 20mm 4mm 20mm 4mm">
                    <h1 style="font-size: 46pt;font-weight: normal;margin: 0;">Strategic Connections Profile Report</h1>
                </div>
            </div>
            <div class="float-left col-40" >
                <div style="padding: 4mm 4mm 1mm 4mm">
                    <img src="<?php echo TDQ_PLUGIN_URI.'assets/images/logo-connections.png'; ?>" style="max-width: 100%;height: auto;margin-top: 30mm;" />
                </div>
            </div>
            <div class="clear"></div>
        </div>
        <div>
           
            <div class="col-60 float-left">
                <div style="padding: 5mm 3mm 2mm 0;">
                    <h2 style=" margin: 0 0 2mm 0;font-size: 16pt" class="text-blue">Your SummarySCP Score-<?php echo $total; ?></h2>
                    <?php if($total <= 45){ $range = 'law-range'; }elseif($total > 45 && $total <= 93){ $range = 'mid-range'; }else{ $range = 'high-range'; } ?>
                    <p>These results fall in the <?php echo $range; ?> of scores. It is quite clear that some areas are well developed, and others are not. To achieve a more balanced picture, the less developed areas must be the focus of personal and leadership development.</p>
                    <img src="<?php echo TDQ_PLUGIN_URI.'tmp/chart-'.$user_id.'.png'; ?>" style="width: auto;height: 305px;margin-top: 5mm;" />
                </div>
            </div>
            <div class="col-40 float-left" style="background: #b8cce4;">
                <div style="padding: 3mm 4mm 3mm 4mm; "> 
                    <h3 style="color: #943634;border-bottom: 1px solid #9bbb59;padding: 0 0 2mm;">Dimension Scores</h3>
                    <h3>Primary - Vertical Network</h3>
        <?php
        $Aspirant_Subordinate_score = $results['score']['Primary']['Aspirant'] + $results['score']['Primary']['Subordinate'];
        echo '<div><div class="cat-name">Aspirant and Subordinate</div><div class="score">'.$Aspirant_Subordinate_score.'</div></div>';
            
        foreach($results['score']['Primary'] as $cat_name => $v){ 
            if($cat_name != 'Aspirant' && $cat_name != 'Subordinate' ){
                echo '<div><div class="cat-name">'.$cat_name.'</div><div class="score">'.$v.'</div></div>';
            }
            
        }
        ?>
                    <h3>Secondary - Horizontal Network</h3>
        <?php
        foreach($results['score']['Secondary'] as $cat_name => $v){ 
            echo '<div><div class="cat-name">'.$cat_name.'</div><div class="score">'.$v.'</div></div>';
        }
        ?>   
                    <div class="line-blue" style="margin-top:8mm; margin-bottom:2mm;"></div>
                    <p style="font-style: italic">The seven dimensions of the Strategic Connections Profile (SCP)&reg; are divided into two main categories:  Primary or Vertical networks, and Secondary or Horizontal networks. Each category of networks has three dimensions.</p>
                </div>
            </div>
                 
        </div>
        <pagebreak>
        <div>
            <div style="padding: 5mm 3mm 2mm 0;">
                <h2 style=" margin: 0 0 2mm 0;font-size: 16pt" class="text-blue">What Your Score Means</h2>
                <p><?php if( $total <= 45 ) { 
                    echo 'A score in this range is an indicator that you have some work to do in the development of your leadership capital. It means that you are just becoming aware of the value and benefits of leadership capital as an individual, professional and or leader. Perhaps you need to use this baseline as a starting point to identify and recognize the strategic networks in which you already have membership.  Leadership development would focus on understanding the value of strategic networks, and recognizing them in your life, your discipline, profession or the organization.  Starting with the areas where your score was low, take one dimension at a time working purposively to develop, strengthen and enhance them until they are strong.  Dimensions that present themselves most frequently, or that are easier for you, will be your greatest immediate opportunity.  Then seeking out or reaching out to individuals or networking opportunities that occasionally present themselves, or that you will need to take time to cultivate would be next.  It is recommended that you re-take this SCP survey in six months to a year to monitor the changes in your scores.'; 
                } elseif( $total > 45 && $total <= 93 ) { 
                    echo 'A score in the medium range shows that you have already begun to develop or have at least explored leadership or personal networks across the seven dimensions. You recognize the significance of having such relationships or networks.  However, they are not strong overall, or one area may be strong while other areas need some work.  It is possible that some of your networks are newly formed, and will need to be nurtured, strengthened and developed into something that can be used for mutual benefit. Are there any strategic relationships or networks that you have difficulty entering? Is there someone in you know that has well developed relationship networks?  Maybe they could be a bridge by connecting with individuals or a group that you are interested in. Your leadership or personal development focus will need to be on building and growing in those areas where the scores are lower, while continuing to monitor and sustain the ones where the scores are higher.  You could also focus on connecting with a sponsor or mentor who can introduce you to membership in new networks. It is recommended that you take the SCP&reg; in a year to monitor your progress in the areas that you have chosen to work on developing.'; 
                }else{ 
                    echo 'A score in the high range means that you are aware of the strategic significance of having personal or leadership capital for information, for benefits, legitimacy, information and for career advancement.  This score indicates that you have developed healthy relationships, and that they are frequently or almost always used. You have taken time to build strong networks across all dimensions, including separating from individuals or groups that are not helpful to you.  As a person and leader, work to maintain or enhance the strength and quality of this personal or leadership capital, working to ensure reciprocity. Are you providing as well as receiving benefits? What, for example, can you do to enhance the quality of these relationships?  Are there some dimensions that might need more work because they are a little more difficult to sustain?  Personal or leadership development could focus in these areas, on sustaining the development of a balanced resource of networks, or becoming someone who mentors someone else. It is recommended that you take the SCP&reg; periodically to monitor your profile so as to be able to make adjustments as needed.';
                } ?></p>
            </div>
        </div>
       
        <div>
            <h2 class="bg-green1" style="background: #f1f1f1;padding: 2mm 4mm 2mm 4mm;margin: 5mm 0 1mm 0; font-size: 16pt;width: 45%;">2 <span class="text-blue">PRIMARY DIMENSIONS</span></h2>
            <div class="clear"></div>
            <div style="width: 20%;float: left;">
                <img src="<?php echo TDQ_PLUGIN_URI.'assets/images/image02.png'; ?>" style="max-width: 100%;height: auto;" />
            </div>
            <div style="width: 40%;float: left;">
                <div style="padding: 2mm 4mm 2mm 4mm">
                    <h3 style="margin: 0;" class="text-carmine">Aspirant Dimension</h3>
                    <p><?php if( $Aspirant_score <= 9 ) { 
                        echo 'Your score here indicates that connections to individuals at the level of leadership or advancement you aspire to are weak. Perhaps you are unsure of how to seek out and develop these relationships. How would you describe the relationship with your boss? Take a look at the people around you who hold the positions you aspire to. Make an effort to get to know them. People you work with or people who work for you may also know the people you want to know. Introduce yourself, or ask for an introduction by a mutual acquaintance. Make an effort to engage in mentoring programs where the leaders you admire are involved. Attend conferences or meetings, read their work.'; 
                    } elseif( $Aspirant_score > 10 && $Aspirant_score <= 15 ) { 
                        echo 'You have begun to develop connections to individuals at the level of leadership or advancement to which you aspire.  You recognize the importance of these networks, and have begun to strategically seek out and develop these relationships. Continue to work on strengthening the relationships you now have through ongoing communication, and to expand them to other individuals who are doing what you want to do.  Strengthen relationships with your superiors.  Confidently invite mentoring relationships, ask their advice or their opinion, attend professional meetings, and participate in projects they are leading to understand and develop a working relationship with them.';
                    } else { 
                         echo 'The relationship networks with individuals at the level of leadership or place you aspire to be is quite strong. You are well on your way. Work on refining and expanding these relationships for full benefit and reciprocity.  Are there some relationships that are stronger than others? Or that might need to have stronger ties?  Do you know this membership network well enough to know what strategic information benefits they can provide you?  Is your social identity and sense of belonging one that needs growth, then share your aspirations and invite them to help you to strategically expand your network capacity with those they believe you should know.';
                    } ?></p>
                </div>
            </div>
            <div style="width: 40%;float: left;">
                <div style="padding: 2mm 4mm 2mm 4mm">
                    <h3 style="margin: 0;" class="text-carmine">Subordinate Dimension</h3>
                    <p>
                    <?php 
                    if( $Subordinate_score <= 9 ) {
                        echo 'This score indicates that the relationship with subordinates, followers or others who work with you is weak.  This network resource has potentially vital connections for you.  Not only are they the ones who make you successful in what you do, but they are also those who can provide information or who can facilitate your interactions with others.  If you can work well with team members and those who work for you this information gets around. So, work diligently to develop these vital relationships into ones that are strong.  The reputation you have and the effectiveness of your performance actually depend on it.';
                    } elseif($Subordinate_score >= 10 && $Subordinate_score <= 15) {
                        echo 'This score indicates that the relationships with your subordinates are relatively good, but they can benefit from increased attention.  The teams you are responsible for are working together, and you are becoming recognized for your effective interactions. Leadership or personal development needs to focus on strategically strengthen these individual and team relationships. Get to know your subordinates and what motivates them. Continue to build these relationships: This will stand you in good stead in your career and life.';
                    } elseif($Subordinate_score >= 16) {
                        echo 'This score indicates that relationships with subordinates or people who work with you are exemplary, and that the teams you are responsible for work efficiently and effectively.  You are respected, subordinates and teams like working with and for you. Ability to work well with others to get the job done and organizational goals met is noticeable.  Leadership or personal development strategy should now include strategic expansion to cross-disciplinary team assignments so that you are developing working relationships in areas outside of your department and area of expertise thus building a broader network.';
                    } ?>
                     </p>
                </div>
            </div>
        </div>
        
        <div style="color: #17365d;font-style: italic; padding: 0.8mm;margin-bottom: 4mm;border: 0.4mm solid #943634">
            <div style="border: 0.4mm solid #943634;padding: 2mm 4mm 2mm 4mm;">
            <span style="font-weight: bold; font-size: 12pt;">Personal Dimensions</span> The personal dimension has two parts. Part 1 focuses on the inside, and looks at your level of self-awareness:  how much you know about your character, feelings, motives and desires.  Part 2 focuses on the outside and looks at self- understanding: how well you can assess the personal impact relationships can have on you. 
            </div>
        </div>
        <div>
            <div class="col-40 bg-green float-left">
                <div style="padding: 5mm 4mm 5mm 4mm;">
                    <p style="font-size: 10pt; border-bottom: 0.3mm solid #9bbb59;padding: 0 0 1mm;margin-bottom: 3mm; font-weight: bold;" class="text-blue">PRIMARY or VERTICAL NETWORKS</p>
                    <p>The primary category looks at the quality of the professional networks you are regularly involved with. They include for example, a supervisor, manager, CEO, bosses; those who are in positions that you aspire to, actual and potential mentors, or advisors: the networks that extend upward. The networks or groups in these dimensions provide information, legitimacy, professional and career advantages. This dimension also has a downward component. It looks at the strength of the relationships you have with those who work with and for you to attain personal, organization or team goals. These include subordinates, teams or groups that you are responsible for, or anyone who reports to or assists you. Then finally, it includes you as the central point -the personal dimension.  It examines the relationship with self and others.</p>
                </div>
            </div>
            <div class="col-60 float-left">
                <div style="padding: 0 0 0 2mm;">
                    <p class="text-blue"><span style="font-size: 12pt;"><strong>Part 1: Personal Dimension</strong><sup>sa</sup></span> is focused inward.  It looks at your level of self-awareness or how well you know yourself. What are the personal habits and disciplines you use to become aware of who you are, and what you need?  Do you take time to reflect, meditate, plan?  Let's see what your profile tells us.</p>
                    <h3 class="text-carmine" style="margin: 5px 0 0;">Self-Awareness</h3>
                    <p style="margin-bottom: 2mm;">
                    <?php if( $Personal_score <= 9 ) {
                        echo 'This score indicates that you may not be spending much time on self-reflection, and self-awareness.  Perhaps you are very busy with work and myriad responsibilities to spend time learning your strengths.  But taking time to reflect on your gifts, performance goals, and progress toward those goals is critically important.  Developing the disciplines of personal reflection, centeredness, and stillness will help to tap into the wisdom that is in you, and allow you to engage in honest self-evaluation. Begin by spending short periods of personal quiet time for reflection, and journaling your self-discoveries.';
                    } elseif( $Personal_score >= 10 && $Personal_score <= 15 ) {
                        echo 'This score gives evidence that you are aware of the significance of an individual’s or leaders’ reflective practice.  You may have begun to schedule time for reflection. Even busy people can schedule personal time, much like vacation time, so your development strategy here would be to guard and maintain personal space for powerful personal practices.  Work to become comfortable with reflection, silence and introspection.  While this profile is not about personality, your personality does have some effect on your tendency or ease in development in this instance.  Especially if you are extroverted it might be difficult at first to set time alone to reflect, as a people-person, but the benefits are great.  Introverts, this is a more comfortable place, but try not to get stuck in this space: be purposive in your reflection and intentionally move toward a personal action plan.';
                    } elseif($Personal_score >= 16 ) {
                        echo 'This score is characteristic of someone who practices self-leadership. Self-discipline, self-awareness, and self-reflection. Wisdom, insight, centeredness, and clarity for decision making are your hallmarks.  The resulting personal and leadership capital will be a source of strength in life, leadership, and professional practice. Self-knowledge, self-awareness and openness to self-evaluation on a regular basis can facilitate knowing the areas where some refinement or attention would be needed and strengthen personal motivation to develop in the areas identified.  This discipline and practice will always be a part of your life.';
                    } ?>
                    </p>
                    
                    <p class="text-blue"><span style="font-size: 12pt;"><strong>Part 2: Personal Dimension</strong><sup>su</sup></span> is directed outward and looks at self-understanding when handling difficult or toxic relationships. Your profile results here can show what seems to be a 'PacMan Effect' which is an immediate tell-tale sign of your profile.</p>
                    <h3 class="text-carmine" style="margin: 5px 0 0;">Toxic Relationship (TR) Dimension</h3>
                    <p style="margin-bottom: 2mm;">
                    <?php if( $Toxic <= 9 ) {
                        echo 'A low toxic relationship score is a good thing.  With the low score you show insightful awareness of, and sensitivity to, negative relationship interactions and how these relationships or networks detract rather than add to your personal or leadership trajectory and effectiveness.  Beyond awareness, you also have developed ability to cut-off or limit them so as to minimize the impact they can have on your self-esteem and self-confidence.  Personal growth and development would be in the area of ongoing refinement of how quickly you are able to identify negative relationships and knowing how to limit negative interactions. This score can show the ‘Pac-Man’ effect.';
                    }
                    elseif( $Toxic >= 10 && $Toxic <= 15 ) {
                        echo 'Scores in the mid-range of are indicative that you may be aware of and recognize the potential impact that negative relationships can have on you and your personal or leadership effectiveness.  However, cutting yourself off from them or knowing how to distance yourself is still a problem.  It could be that you have not yet mastered letting go of some relationships, even though you are aware that they are destructive or eating away at your self-esteem and your confidence. Or, it could be that once you have ended one negative relationship another is easily entered.  Personal development is recommended in the areas of learning to recognize the signs of toxic relationships early on so that you can prevent them from becoming destructive to you. This score will show a modified ‘Pac-Man’ effect reflecting that some further growth needs to happen in this area.  Practicing cutting off toxic relationships as soon as you identify the tell-tale signs until you are confident in doing so, and replacing them with other positive relationships will be a critical action item here.';
                    } elseif( $Toxic >= 16 ) {
                        echo 'This high score indicates a certain naiveté or habitual lack of ability to discern the negative effect of toxic relationships on your self-awareness, self-confidence, and effectiveness. You may be aware that these relationships or groups are harmful to you, or holding you back, but have not yet mastered ability to separate yourself from them.  Your score will not show a  ‘Pac-Man’ effect or very little effect. Developing ability to recognize toxic relationships, and practicing ending or limiting them until you are confident doing so (mastery) will be first steps for you. Then begin work on building self-esteem and understanding your personal value will help to increase your self-awareness and self-confidence. It is recommended that you review your profile results after six months, because this area will ultimately have influence on your ability to build on or strengthen the other important strategic networks, and to be fully effective in life and leadership.';
                    } ?>
                    </p>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        <div>
            <div>
                <div class="col-50 float-left">&nbsp;</div>
                <div class="col-50 float-left"><h2 class="bg-green" style="padding: 2mm 4mm 2mm 4mm;margin: 5mm 0 1mm 0; font-size: 16pt;">3 <span class="text-blue">Secondary Dimensions</span></h2></div>
            </div>
            <div class="col-50 float-left">
                <img src="<?php echo TDQ_PLUGIN_URI.'assets/images/img03.jpg'; ?>" style="max-width: 100%;height: auto;" />
            </div>
            <div class="col-50 float-left">
                <div style="padding: 0 0 1mm 4mm;">
                    <h3 class="text-carmine" style="margin: 0;">Mentor/Advisory Dimension</h3>
                    <p style="margin-bottom: 2mm;">
                    <?php if($Mentor <= 9) {
                        echo 'A low score in the mentor-advisory dimension means that you are somewhat independent and may not ordinarily seek out the advice of those who are experienced and wiser than you are.  These individuals can be strong essential strategic resources of information, and on how to further develop your relational networks.  The focus of your personal or leadership development would be directed towards fostering the strategic development of these mentoring relationships.  Make contact with someone you admire, or take part in specific mentoring opportunities with complimentary skills in the areas that you need or desire in career and life.';
                    } elseif( $Mentor >= 10 && $Mentor <= 15 ) {
                        echo 'A score in this range says that you recognize that your mentor advisory network can be one of the most powerful strategic networks you can ever develop.  These individuals have not only a vested interest in your development as a leader, but they agree to participate in your developmental process, providing the necessary wisdom, mentoring and support.  Seek out or identify one or two persons who are willing to invest in you in this way. Here the quality of the individual’s contribution to your life is more important than the quantity of mentors you select. Again, you can initiate the contact and ask them whether they would be willing to serve in this capacity for you, then enjoy the adventure.';
                    } elseif( $Mentor >= 16 ) {
                        echo ' This score indicates you understand that in order to realize optimal and ultimate purpose in life, or to move to the next level, you need individuals strategically placed in relational networks that will not only recognize the gift and purpose in you, but who will identify it and specifically nurture it through to actualization. You have paid close attention to the development and diversity of your personal and leadership strategic networks. Personal development focus would be to identify or be connected to these individual mentor advisors.  Some relationships will be stronger than others, some closer than others.  The key is to know when to tap into any of these individuals at any of these relational levels at the time they are needed. Continue to maintain and sustain the network connections of most value to you adding to them as you move higher and deeper in your purpose.';
                    } ?>
                    </p>
                </div>
                
            </div>
              
            <div class="clear"></div>
        </div>
        <div style="color: #17365d;font-style: italic; padding: 0.8mm;margin-bottom: 4mm;border: 0.4mm solid #943634">
            <div style="border: 0.4mm solid #943634;padding: 2mm 4mm 2mm 4mm;">
                <p style="text-align: center;"><span style="font-weight: bold; font-size: 12pt;">The 'PacMan Effect' of Toxic Relationships</span></p>
                The connection to 'PacMan' in this dimension is to the shape and experience: it is your recognition that toxic relationships need to be limited or eliminated if possible. Ability to eliminate them or to prevent them from hindering your progress and growth is critical to your success.  If allowed to continue unchecked they will not only destroy your self-confidence and self-esteem, but your capacity for effective life and leadership. So, in this area a low score is a good thing. A high score indicates that work needs to be done in this area.  This dimension is directed outward but the effect on you is inward. It crosses all of the other dimensions in some way, as you can encounter toxic relationships in all of the dimensional categories described.
            </div>
        </div>
         
        <div>
            <div class="col-60 float-left">
                <div style="padding: 2mm 4mm 2mm 0;">
                    <p class="text-blue"><span style="font-size: 12pt;"><strong>Peer/Professional Dimension</strong></span></p>
                    <p style="margin-bottom: 4mm;">
                    <?php if( $Professional <= 9 ) {
                        echo ' Peer and professional colleagues are one of your broadest sources of networking opportunities. A low score here means you need to seek out memberships in professional associations, so that you can increase your network of colleagues and peers. These can be developed in your professional practice, or related areas of professional practice and of course, areas of personal interest.  Professional colleagues can also serve as informal mentors and accountability networks, sources of vital information that can contribute to your career advancement. Working to develop networks at this level can result in exponential rewards, raising your profile, and information benefits.';
                    } elseif( $Professional >= 10 && $Professional <= 15 ) {
                        echo ' A score in the medium range in this dimension indicates that you have good relationships with your colleagues, understand and recognize their strategic importance as contributors to your personal or leadership capital.  You have begun to develop them and need to deepen them.  Your professional peers are one of your more powerful sources of connections, information, benefits, and career advancement.  Personal or leadership development strategy should include an expansion of these networks to other disciplines or areas of interest that open up opportunities to expand your valuable connections, and to share your expertise with others.';
                    } elseif( $Professional >= 16 ) {
                        echo 'Your score indicates that you have broad, well-developed peer and professional networks.  Your active involvement in professional groups is not only strategic, but with purpose and strong.  Time and effort have been spent in maintaining and sustaining these interactive relational networks, and you have become well known and well-respected by your peers.  Personal or Leadership development focus would now be on expanding or deepening professional networks in your area of professional interest, and to be alert to where opportunities present themselves for network expansion and even for mentoring and developing others in your networks.';
                    } ?>
                    </p>
                    <p class="text-blue"><span style="font-size: 12pt;"><strong>Global/Social Dimension</strong></span></p>
                    <p style="margin-bottom: 2mm;">
                    <?php if( $Global <= 9 ) {
                        echo 'This is a highly rewarding and reciprocal network base to develop because it has far-reaching effect.  The intentional development of your global network can be initiated with memberships in social media forums where like-minded professionals can be found.  Forums such as Linked In, Twitter and Facebook can connect you to the world. Personal or leadership development growth could focus on becoming a part of these networks, making connections with individuals and groups of interest. It will also require a willingness to consistently maintain ongoing interactions with members in the networks to which you belong.';
                    } elseif( $Global >= 10 && $Global <= 15 ) {
                        echo 'A score in the medium range means that you have recognized the strategic value of being connected on social media to global social groups that are professionally related to areas of interest, aspiration or your area of expertise.  Personal or leadership development focus would be to work on ways the social media networks, formal or informal, could be leveraged or used to attract strategic leadership connections, developing and manage your professional image as you develop your leadership voice, identity and presence.';
                    } elseif( $Global >= 16 ) {
                        echo 'This score indicates you understand the powerful strategic value of being part of global or social networks. You have worked on your professional profile, the message used to portray your voice and expertise. You are recognized and others follow you.  While these are considered to be looser networks, these signal a much broader audience of followers. Your personal influence and leadership capital is exponentially expanded because they are so dispersed and global.  Personal growth or leadership development would include work on becoming a thought leader whose followers are engaged and interactive world changers.';
                    }
                    ?>
                    </p>

                    <p class="text-blue"><span style="font-size: 12pt;"><strong>Accountability Dimension</strong></span></p>
                    <p style="margin-bottom: 2mm;">
                    <?php if( $Accountability <= 9 ) {
                        echo 'A low score in your accountability dimension may mean that you are self-reliant. An accountability group is a vital part of your personal capital.  These are individuals, or peers with whom you have a close relationship.  This group is also committed to your successful career, to advancing your goals, and assisting you with work in your areas of weakness.  They also will keep you focused on the attainment of your stated goals by monitoring your progress.  As a strong support system, they may also be a strategic network group with ability to acquaint you with, or introduce you to, networks that have strategic benefits for your personal or leadership development.';
                    } elseif( $Accountability >= 10 && $Accountability <= 15 ) {
                        echo 'A medium score here indicates you are recognizing the value of having a few close relationships with individuals who have your personal success at heart.  They are trusted supporters or coaches, and they know you well enough to be able to identify your areas of weakness and are willing to point out areas of needed growth.  The close relationships allow them to see you in situations that not all mentors, peers nor advisory networks can, and so they are invaluable sources of feedback to you if you will listen.  For a more balanced well-rounded approach to your personal or leadership identity your growth or development in the area of an accountability group needs to focus on strengthening the relationships and your purpose for having  them.';
                    } elseif( $Accountability >= 16 ) {
                        echo 'A high score is indicative of you having worked to build a strong solid accountability group that is trusted.  You are open to their advice, wisdom and encouragement because you know they have your best interests at heart. Perhaps they hold to account for lack of progress or push you toward your goals.  Meeting regularly with this group for feedback and input, is a strategic means of strengthening themselves-confidence. Your development would focus on growing your accountability group, to include mentors, addressing new areas to work on, or refining the type of feedback and input you desire from them.';
                    }
                    ?>
                    </p>
                    
                </div>
            </div>
            <div class="col-40 bg-green float-left">
                <div style="padding: 5mm 4mm 5mm 4mm;">
                    <p style="font-size: 10pt; border-bottom: 0.3mm solid #9bbb59;padding: 0 0 1mm;margin-bottom: 3mm; font-weight: bold;" class="text-blue">SECONDARY or HORIZONTAL NETWORKS</p>
                    <p><strong>Your secondary or horizontal</strong> dimensions assess personal accountability circles, peer and professional groups, global, and social network relationships. These networks extend from smaller more intimate groups, to larger professional groups, to the world stage of social media.  They comprise your information and bridging networks.</p>
                    <div class="line-blue" style="margin-top:8mm; margin-bottom:8mm;"></div>
                    <p style="margin-bottom: 4mm;"><img src="<?php echo TDQ_PLUGIN_URI.'assets/images/mentor-minute.png'; ?>" style="max-width: 100%;height: auto;" /></p>
                    <p style="font-style: italic;color:#913634">"Strategic Connections are the most powerful leadership intangible.  It's not always what you know, but who knows you that makes the difference."</p>
                </div>
            </div>
            
            <div>
            <br><BR><br><BR><br><BR><br><BR><br><BR><br><BR><br><BR>
                <div class="col-40 bg-green float-left">
                    <h2 class="bg-green" style="padding: 2mm 4mm 2mm 4mm;margin: 1mm 0 1mm 0;font-size: 16pt;line-height:1;">4 <span class="text-blue">Resources</span></h2>

                    <div style="padding: 5mm 4mm 5mm 4mm;background: #b8cce4;">
                        <p style="font-size: 12pt; border-bottom: 0.3mm solid #9bbb59;padding: 0 0 1mm;margin-bottom: 3mm; font-weight: bold;" class="text-blue">Carmel Connections Inc.</p>
                        <p style="margin-bottom: 2mm;">
                        <?php //echo (!empty($uname)) ? $uname : 'Carmela Nation' ; ?><br />
                        <?php echo (!empty(get_option('tdq_phone'))) ? get_option('tdq_phone') : '833-544-LEAD' ; ?><br />
                        2500 Quantum Lakes Drive Ste 203, Boynton Beach, FL 33426<br />
                        info@carmelananton.com
                        </p>
                        <p style="font-style: italic;margin-bottom: 5mm;">'build  leadership capital'</p>
                        
                        <p style="margin-bottom: 8mm;margin-top: 2mm;">
                        Find us on the Web:<br />
                        www.drcarmelananton.com 
                        </p>
                        <p style="margin-bottom: 8mm;">
                            <img  src="<?php echo TDQ_PLUGIN_URI.'assets/images/logo-connections.png'; ?>" style="max-width: 100%;height: auto;" />
                        </p>
                        <p class="text-blue" style="font-weight: bold;">Resources:</p>
                        <p>Book <em>'Building Power Networks for Leadership & Life'</em> with the Strategic Connections Profile (SCP)<sup>&reg;</sup></p>
                    </div>
                </div>
                <div class="col-60 float-left">
                    <div style="padding: 0 0 0 2mm;">
                        <p class="text-blue" style="font-size: 12pt;"><strong>About the SCP</strong><sup>&reg;</sup></p>
                        <p style="margin-bottom: 2mm;">
                            The Strategic Connections Profile (SCP<sup>&reg;</sup>) is a 28-item survey that looks at seven kinds of strategic relationships -the ones you need and the ones you don't need. Each question has a minimum score of 1 point and a maximum score of 5 points based on the scale below.  Select the number that is currently true of you. Summary scores range from:  Low (0-45); Medium (46-93); to High (94-140). Be realistic in your assessment and do not spend an excessive amount of time deliberating over the responses. There are no right or wrong answers. It is the first step onthe journey toward building strong, and viable strategic connections.  
                        </p>
                        
                        <p class="text-blue" style="font-size: 12pt;"><strong>Best uses for the SCP</strong><sup>&reg;</sup></p>
                        <p style="margin-bottom: 2mm;">
                            The SCP is designed for Personal Leadership development and is screening tool that immediately shows you where training, coaching and leadership development efforts are optimally focused.  Best uses for the results are: <br />
                             
                            <ol type="1" style="font-weight: bold; margin: 0; padding-left: 5mm;">
                                <li>Developing your personal leadership development plan (PLDP), </li>
                                <li>Deciding on Executive Coaching Needs</li>
                                <li>Planning for Employee Training and Leadership Development</li>
                                <li>Facilitating Accountability Groups and Teams</li>
                             
                            </ol>
                        </p>
                        <p style="margin-top: 3mm;">To learn more about what your results mean or receive in-depth report on how to strengthen you SCP profile for only $<?php echo get_option('tdq_upgrade_price'); ?>. Or,apply to contact Dr. Nanto nwww.drcarmelananton.com or order the Book: <em>Building Power Networks for Leadership and Life with the Strategic Connections Profile (SCP)<sup>&reg;</sup></em>
                        Groups and company orders are welcomed.
                        </p>
                        <p style="margin-top: 5mm;">
                           Dr. Carmela Nanton is Founder and CEO of Carmel Connections Inc. She is a Board Certified Executive and Leadership Coach, consultant, trainer and speaker. As leadership systems and methods strategist who has developed leaders for the last 2 decades, across all sectors of business
and life she offers coaching and training in all areas covered by the SCP. The SCP was developed after recognizing the heart of leadership is an influential relationship with the one who chooses to follow you. This means that the leader's most powerful 'intangible' asset, or their personal leadership capital, lies in the strategic connections that they have. It has powerful effect on your effectiveness, success, and advancement in career and goals.  
                        </p>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </body>
</html>