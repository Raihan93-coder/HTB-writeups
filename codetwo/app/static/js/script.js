document.addEventListener('DOMContentLoaded', function() {
    // Run Code
    document.getElementById('runButton').addEventListener('click', () => {
        const code = document.getElementById('codeEditor').value;
        
        if (!code) {
            document.getElementById('outputContainer').textContent = "Please enter some JavaScript code to run.";
            return;
        }

        fetch('/run_code', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ code: code })
        })
        .then(response => response.json())
        .then(data => {
            if (data.result) {
                document.getElementById('outputContainer').textContent = data.result;
            } else if (data.error) {
                document.getElementById('outputContainer').textContent = `Error: ${data.error}`;
            }
        })
        .catch(error => {
            document.getElementById('outputContainer').textContent = `An error occurred: ${error}`;
        });
    });

    // Load saved code into the editor
    document.querySelectorAll('.code-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const code = this.getAttribute('data-code');
            document.getElementById('codeEditor').value = code;
        });
    });

    // Save code
    document.getElementById('saveButton').addEventListener('click', () => {
        const code = document.getElementById('codeEditor').value;

        if (!code) {
            alert("Please enter some code to save.");
            return;
        }

        fetch('/save_code', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ code: code })
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                alert(data.message);
                location.reload(); // Refresh to show the new saved code
            } else if (data.error) {
                alert(`Error: ${data.error}`);
            }
        })
        .catch(error => {
            alert(`An error occurred: ${error}`);
        });
    });

    // Delete code
    document.querySelectorAll('.delete-code-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const codeId = this.getAttribute('data-code-id');
            
            if (!confirm("Are you sure you want to delete this code?")) return;

            fetch(`/delete_code/${codeId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    alert(data.message);
                    location.reload(); // Refresh to remove the deleted code
                } else if (data.error) {
                    alert(`Error: ${data.error}`);
                }
            })
            .catch(error => {
                alert(`An error occurred: ${error}`);
            });
        });
    });
});
