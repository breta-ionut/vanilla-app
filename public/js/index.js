function showLoginPrompt(noRetry) {
    if (noRetry > 3) {
        alert('You already had 3 attempts of entering the PIN. The card is now blocked');

        window.reload();
    }

    let username = prompt('Username');
    let pin = prompt('PIN');

    $.ajax('/api/card/authenticate', {
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            holderName: username,
            rawPin: pin,
        })
    }).then(() => {
        enableOperations();
    }).catch(() => {
        alert('Wrong PIN! Please try again');

        showLoginPrompt(noRetry + 1);
    })
}

function enableOperations() {
    $('#operations').show();

    $('#withdraw').click(() => {
        let amount = parseFloat($('#withdraw-value').val())

        $.ajax('/api/card/withdraw', {
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                amount: amount,
            })
        }).then(() => {
            alert('Success!')
        })
        .catch(() => {
            alert('Something went wrong! You probably lack the money!')
        })
        .finally(() => {
            $('#withdraw-value').val(0)
        })
    });

    $('#deposit').click(() => {
        let amount = parseFloat($('#deposit-value').val())

        $.ajax('/api/card/deposit', {
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                amount: amount,
            }),
        }).then(() => {
            alert('Success!')
        }).catch(() => {
            alert('Something went wrong!')
        }).finally(() => {
            $('#deposit-value').val(0)
        })
    });

    $('#get-sold').click(() => {
        $.ajax('/api/card/sold', {
            type: 'GET',
        }).then((data) => {
            alert('Your sold is: ' + data.sold);
        }).catch(() => {
            alert('Something went wrong!')
        })
    })
}

$(document).ready(() => {
    showLoginPrompt(1)
})
