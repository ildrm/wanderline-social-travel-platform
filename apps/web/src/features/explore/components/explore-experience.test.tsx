import { cleanup, render, screen } from "@testing-library/react";
import userEvent from "@testing-library/user-event";
import { afterEach, describe, expect, it } from "vitest";
import { journeys } from "../data/journeys";
import { ExploreExperience } from "./explore-experience";

afterEach(cleanup);

describe("ExploreExperience", () => {
  it("filters journeys and recovers from an empty result", async () => {
    const user = userEvent.setup();
    render(<ExploreExperience initialJourneys={journeys} />);
    const search = screen.getByPlaceholderText("Where to?");
    await user.type(search, "Tokyo");
    expect(screen.getAllByText("Japan in Good Company")).toHaveLength(2);
    expect(screen.queryByText("Alpine Connections")).not.toBeInTheDocument();
    await user.clear(search);
    await user.type(search, "Atlantis");
    expect(screen.getByText("No journeys match those filters yet.")).toBeInTheDocument();
    await user.click(screen.getByRole("button", { name: "Clear filters" }));
    expect(screen.getAllByText("The Grand European Loop")).toHaveLength(2);
  });

  it("selects and saves a journey", async () => {
    const user = userEvent.setup();
    render(<ExploreExperience initialJourneys={journeys} />);
    await user.click(screen.getByRole("button", { name: /Coastal Italy: People & Places/i }));
    await user.click(screen.getByRole("button", { name: "Save" }));
    expect(screen.getByRole("button", { name: "Saved" })).toHaveAttribute("aria-pressed", "true");
  });
});
