const fs = require('fs');

// Load the JSON data
const data = JSON.parse(fs.readFileSync('info.json', 'utf8'));

function respondToUser(query) {
  const lowerQuery = query.toLowerCase();

  if (lowerQuery.includes("apply for id") || lowerQuery.includes("id application")) {
    const info = data.services.id_application;
    return `
🆔 **ID Application Info**

📄 **Requirements**:
- ${info.requirements.join('\n- ')}

🔄 **Process**:
- ${info.process.join('\n- ')}

⏳ **Duration**: ${info.duration}

🌐 **Online Application**: ${info.online_services}
    `;
  }

  return "Sorry, I couldn't find information on that. Try asking about 'ID application'.";
}

// Example usage
console.log(respondToUser("How do I apply for an ID at Home Affairs?"));
