const { render, useState } = wp.element;

const Votes = () => {
  const [votes, setVotes] = useState(0);
  const addVote = () => {
    setVotes(votes + 1);
  };
  return (
    <div>
      <h2>{votes} Votes</h2>
      <p>
        <button onClick={addVote} className="p-2 text-teal-100 bg-teal-700 rounded">Vote!</button>
      </p>
    </div>
  );
};
render(<Votes />, document.getElementById(`react__votes`));