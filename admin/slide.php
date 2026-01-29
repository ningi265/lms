<!--slider-->
<div class="container-fluid" style="padding: 0;">
    <div class="row" style="margin: 0;">
        <div class="col-md-12" style="padding: 0;">
            <div id="slidy-container" style="width: 100%; overflow: hidden;">
                <figure id="slidy">
                    <img class="img-responsive" src="images/vnhs1.jpg" alt="">
                    <img class="img-responsive" src="images/vnhs2.jpg" alt="">
                    <img class="img-responsive" src="images/vnhs3.jpg" alt="">
                    <img class="img-responsive" src="images/vnhs4.jpg" alt="">
                    <img class="img-responsive" src="images/vnhs5.jpg" alt="">
                    <img class="img-responsive" src="images/vnhs6.jpg" alt="">
                    <img class="img-responsive" src="images/vnhs7.jpg" alt="">
                </figure>
            </div>
        </div>
    </div>
</div>

<style>
    /* Make slider container full width */
    #slidy-container {
        width: 100%;
        overflow: hidden;
        position: relative;
        margin: 0;
        padding: 0;
    }
    
    /* Make slider fill entire space */
    #slidy {
        margin: 0;
        padding: 0;
        position: relative;
        width: 700%; /* 7 images × 100% */
        height: 400px; /* Adjust height as needed */
        animation: slidy-animation 21s infinite;
        -webkit-animation: slidy-animation 21s infinite;
        -moz-animation: slidy-animation 21s infinite;
        -o-animation: slidy-animation 21s infinite;
    }
    
    /* Make images fill their container */
    #slidy img {
        float: left;
        width: 14.2857%; /* 100% / 7 images */
        height: 100%;
        object-fit: cover; /* This will crop images to fill container */
        display: block;
        margin: 0;
        padding: 0;
    }
    
    /* For browsers that don't support object-fit */
    @supports not (object-fit: cover) {
        #slidy img {
            height: auto;
            min-height: 400px; /* Fallback height */
        }
    }
    
    /* Keyframes for the sliding animation */
    @keyframes slidy-animation {
        0% { transform: translateX(0); }
        12.5% { transform: translateX(0); }
        14.28% { transform: translateX(-14.2857%); }
        26.78% { transform: translateX(-14.2857%); }
        28.56% { transform: translateX(-28.5714%); }
        41.06% { transform: translateX(-28.5714%); }
        42.84% { transform: translateX(-42.8571%); }
        55.34% { transform: translateX(-42.8571%); }
        57.12% { transform: translateX(-57.1428%); }
        69.62% { transform: translateX(-57.1428%); }
        71.4% { transform: translateX(-71.4285%); }
        83.9% { transform: translateX(-71.4285%); }
        85.68% { transform: translateX(-85.7142%); }
        98.18% { transform: translateX(-85.7142%); }
        100% { transform: translateX(0); }
    }
    
    /* Browser prefixes for compatibility */
    @-webkit-keyframes slidy-animation {
        0% { -webkit-transform: translateX(0); }
        12.5% { -webkit-transform: translateX(0); }
        14.28% { -webkit-transform: translateX(-14.2857%); }
        26.78% { -webkit-transform: translateX(-14.2857%); }
        28.56% { -webkit-transform: translateX(-28.5714%); }
        41.06% { -webkit-transform: translateX(-28.5714%); }
        42.84% { -webkit-transform: translateX(-42.8571%); }
        55.34% { -webkit-transform: translateX(-42.8571%); }
        57.12% { -webkit-transform: translateX(-57.1428%); }
        69.62% { -webkit-transform: translateX(-57.1428%); }
        71.4% { -webkit-transform: translateX(-71.4285%); }
        83.9% { -webkit-transform: translateX(-71.4285%); }
        85.68% { -webkit-transform: translateX(-85.7142%); }
        98.18% { -webkit-transform: translateX(-85.7142%); }
        100% { -webkit-transform: translateX(0); }
    }
    
    @-moz-keyframes slidy-animation {
        0% { -moz-transform: translateX(0); }
        12.5% { -moz-transform: translateX(0); }
        14.28% { -moz-transform: translateX(-14.2857%); }
        26.78% { -moz-transform: translateX(-14.2857%); }
        28.56% { -moz-transform: translateX(-28.5714%); }
        41.06% { -moz-transform: translateX(-28.5714%); }
        42.84% { -moz-transform: translateX(-42.8571%); }
        55.34% { -moz-transform: translateX(-42.8571%); }
        57.12% { -moz-transform: translateX(-57.1428%); }
        69.62% { -moz-transform: translateX(-57.1428%); }
        71.4% { -moz-transform: translateX(-71.4285%); }
        83.9% { -moz-transform: translateX(-71.4285%); }
        85.68% { -moz-transform: translateX(-85.7142%); }
        98.18% { -moz-transform: translateX(-85.7142%); }
        100% { -moz-transform: translateX(0); }
    }
    
    @-o-keyframes slidy-animation {
        0% { -o-transform: translateX(0); }
        12.5% { -o-transform: translateX(0); }
        14.28% { -o-transform: translateX(-14.2857%); }
        26.78% { -o-transform: translateX(-14.2857%); }
        28.56% { -o-transform: translateX(-28.5714%); }
        41.06% { -o-transform: translateX(-28.5714%); }
        42.84% { -o-transform: translateX(-42.8571%); }
        55.34% { -o-transform: translateX(-42.8571%); }
        57.12% { -o-transform: translateX(-57.1428%); }
        69.62% { -o-transform: translateX(-57.1428%); }
        71.4% { -o-transform: translateX(-71.4285%); }
        83.9% { -o-transform: translateX(-71.4285%); }
        85.68% { -o-transform: translateX(-85.7142%); }
        98.18% { -o-transform: translateX(-85.7142%); }
        100% { -o-transform: translateX(0); }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var slidy = document.getElementById('slidy');
        if (slidy) {
            // Set slider height based on first image or container
            var container = document.getElementById('slidy-container');
            var firstImg = slidy.getElementsByTagName('img')[0];
            
            // Optional: Make slider responsive height
            function setSliderHeight() {
                var containerWidth = container.clientWidth;
                var aspectRatio = 16/9; // Adjust to your preference (16:9, 4:3, etc.)
                var calculatedHeight = containerWidth / aspectRatio;
                
                // Set minimum and maximum heights
                calculatedHeight = Math.max(calculatedHeight, 300); // min 300px
                calculatedHeight = Math.min(calculatedHeight, 600); // max 600px
                
                slidy.style.height = calculatedHeight + 'px';
            }
            
            // Set initial height
            setSliderHeight();
            
            // Update height on window resize
            window.addEventListener('resize', setSliderHeight);
            
            // Add animation with prefixes for compatibility
            slidy.style.animation = 'slidy-animation 21s infinite';
            slidy.style.webkitAnimation = 'slidy-animation 21s infinite';
            slidy.style.mozAnimation = 'slidy-animation 21s infinite';
            slidy.style.oAnimation = 'slidy-animation 21s infinite';
        }
    });
</script>