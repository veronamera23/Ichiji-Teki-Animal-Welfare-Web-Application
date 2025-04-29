document.addEventListener("DOMContentLoaded", function() {
    const donationType = document.getElementsByName('donation_type');
    const monetaryDetails = document.getElementById('monetary_details');
    const inKindDetails = document.getElementById('in_kind_details');

    Array.from(donationType).forEach(function(element) {
        element.addEventListener('change', function() {
            if (this.value === 'monetary') {
                monetaryDetails.style.display = 'block';
                inKindDetails.style.display = 'none';
            } else if (this.value === 'in-kind') {
                monetaryDetails.style.display = 'none';
                inKindDetails.style.display = 'block';
            }
        });
    });

    const partnershipType = document.getElementById('partnership_type');
    const eventDetails = document.getElementById('event_details');
    const promotionalDetails = document.getElementById('promotional_details');
    const otherDetails = document.getElementById('other_details');

    if (partnershipType) {
        partnershipType.addEventListener('change', function() {
            eventDetails.style.display = 'none';
            promotionalDetails.style.display = 'none';
            otherDetails.style.display = 'none';

            if (this.value === 'event') {
                eventDetails.style.display = 'block';
            } else if (this.value === 'promotional') {
                promotionalDetails.style.display = 'block';
            } else if (this.value === 'other') {
                otherDetails.style.display = 'block';
            }
        });
    }
});
