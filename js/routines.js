document.addEventListener("DOMContentLoaded", function () {
  const routinesList = document.getElementById("routinesList");

  // Sample routines data (in a real app, this would come from a server)
  const routines = [
    { name: "Bro Split", description: "Classic muscle group split routine" },
    {
      name: "PPL",
      description: "Push, Pull, Legs routine for balanced development",
    },
    { name: "Full Body", description: "Full body workout 3 times a week" },
    {
      name: "Upper/Lower",
      description: "Alternating upper and lower body workouts",
    },
  ];

  // Function to create a routine card
  function createRoutineCard(routine) {
    const card = document.createElement("div");
    card.className = "col-md-4 mb-4";
    card.innerHTML = `
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">${routine.name}</h5>
                    <p class="card-text">${routine.description}</p>
                    <a href="#" class="btn btn-primary">View Details</a>
                </div>
            </div>
        `;
    return card;
  }

  // Add routine cards to the page
  routines.forEach((routine) => {
    routinesList.appendChild(createRoutineCard(routine));
  });

  // Check if user is logged in
  const user = JSON.parse(localStorage.getItem("user"));
  if (user) {
    const welcomeMessage = document.createElement("p");
    welcomeMessage.className = "text-center mb-4";
    welcomeMessage.textContent = `Welcome back, ${user.email}!`;
    routinesList.parentNode.insertBefore(welcomeMessage, routinesList);
  }
});
