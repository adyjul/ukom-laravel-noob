//post data
function postDataWithPromise(url,formData)
{
    return new Promise((resolve,rejected) =>{
        fetch(url,{
            method: "POST",
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            body: formData
        })
        .then(res => res.json())
        .then(rs => {
            if(rs.code == 201 || rs.code == 200 ){
               resolve(rs)
            }else{
                throw Object.values(rs.errors)
            }
        })
        .catch(err => {
            rejected(err)
        })
    } )
}


//post data with JSON stringify
function postDataWithJsonStringify(url,...data)
{
    console.log(data[0]);
    return new Promise((resolve,rejected) =>{
        fetch(url,{
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            body: JSON.stringify(data[0])
        })
        .then(res => res.json())
        .then(rs => {
            if(rs.code == 201 || rs.code == 200 ){
               resolve(rs)
            }else{
                throw rs.message
            }
        })
        .catch(err => {
            rejected(err)
        })
    } )
}


//select with post
function select(id, url,input)
{
    $(`#${id}`).select2({
        minimumInputLength: input,
        theme: 'bootstrap4',
        ajax: {
            url,
            dataType: 'json',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data: function(term) {
                return (JSON.stringify({
                    searchString: term.term
                }))
            },
            processResults: function(data, page) {
                return {
                    results: data.data
                }
            }
        }
    })
}
